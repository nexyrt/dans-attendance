<?php

namespace App\Livewire\Director;

use App\Models\User;
use App\Models\Department;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Cake\Chronos\Chronos;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class Users extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    // Form properties for modals
    public $userId;
    public $name;
    public $email;
    public $password;
    public $role_select;
    public $department_id;
    public $phone_number;
    public $birthdate;
    public $salary;
    public $address;

    // Password reset properties
    public $resetPasswordId = null;
    public $newPassword = '';

    // User deletion properties
    public $userIdBeingDeleted = null;

    // View user property
    public $viewUserId = null;

    // Event listeners
    protected $listeners = [
        'edit' => 'edit',
        'viewUser' => 'viewUser',
        'confirmPasswordReset' => 'confirmPasswordReset',
        'confirmUserDeletion' => 'confirmUserDeletion',
        'userDeleted' => '$refresh'
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Avatar')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=3B82F6&background=DBEAFE'),
                
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        return $record->name . '<br><span class="text-gray-500 text-xs">' . $record->email . '</span>';
                    })
                    ->html(),
                
                TextColumn::make('department.name')
                    ->label('Department')
                    ->placeholder('N/A')
                    ->sortable(),
                
                BadgeColumn::make('role')
                    ->label('Role')
                    ->colors([
                        'success' => 'staff',
                        'info' => 'manager', 
                        'danger' => 'admin',
                        'warning' => 'director',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                
                TextColumn::make('phone_number')
                    ->label('Contact Info')
                    ->formatStateUsing(function ($record) {
                        $contact = $record->phone_number ?? 'N/A';
                        if ($record->birthdate) {
                            $contact .= '<br><span class="text-gray-500 text-xs">Born: ' . \Cake\Chronos\Chronos::parse($record->birthdate)->format('M d, Y') . '</span>';
                        }
                        return $contact;
                    })
                    ->html()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->placeholder('All Departments'),
                
                SelectFilter::make('role')
                    ->options([
                        'staff' => 'Staff',
                        'manager' => 'Manager',
                        'admin' => 'Admin', 
                        'director' => 'Director',
                    ])
                    ->placeholder('All Roles'),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->action(fn ($record) => $this->viewUser($record->id)),
                    
                    Action::make('whatsapp')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->color('success')
                        ->label('WhatsApp')
                        ->url(fn ($record) => $this->getWhatsAppUrl($record))
                        ->openUrlInNewTab()
                        ->visible(fn ($record) => !empty($record->phone_number)),
                    
                    Action::make('edit')
                        ->icon('heroicon-o-pencil')
                        ->color('warning')
                        ->action(fn ($record) => $this->edit($record->id)),
                    
                    Action::make('resetPassword')
                        ->icon('heroicon-o-key')
                        ->color('gray')
                        ->action(fn ($record) => $this->confirmPasswordReset($record->id)),
                    
                    Action::make('delete')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->action(fn ($record) => $this->confirmUserDeletion($record->id)),
                ])
                ->label('Actions')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('gray')
                ->button()
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add New User')
                    ->icon('heroicon-o-plus')
                    ->action('create')
                    ->color('primary'),
            ])
            ->searchable()
            ->defaultSort('name', 'asc')
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10);
    }

    // Create or edit user form
    public function create()
    {
        $this->resetValidation();
        $this->reset(['userId', 'name', 'email', 'password', 'role_select', 'department_id', 'phone_number', 'birthdate', 'salary', 'address']);
        $this->dispatch('open-modal', 'create-user-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';  // Don't fill password field for security
        $this->role_select = $user->role;
        $this->department_id = $user->department_id;
        $this->phone_number = $user->phone_number;
        $this->birthdate = $user->birthdate ? Chronos::parse($user->birthdate)->format('Y-m-d') : null;
        $this->salary = $user->salary;
        $this->address = $user->address;

        $this->dispatch('open-modal', 'edit-user-modal');
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $this->userId ? Rule::unique('users')->ignore($this->userId) : Rule::unique('users'),
            ],
            'role_select' => 'required|in:staff,manager,admin,director',
            'department_id' => 'nullable|exists:departments,id',
            'phone_number' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
        ];

        // Only require password for new users
        if (!$this->userId) {
            $rules['password'] = 'required|min:8';
        } elseif ($this->password) {
            $rules['password'] = 'min:8';
        }

        $this->validate($rules);

        // Create or update user
        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role_select,
                'department_id' => $this->department_id,
                'phone_number' => $this->phone_number,
                'birthdate' => $this->birthdate,
                'salary' => $this->salary,
                'address' => $this->address,
            ];

            // Update password if provided
            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            $user->update($userData);

            $this->dispatch('close-modal', 'edit-user-modal');
            Notification::make()
                ->title('User updated successfully')
                ->success()
                ->send();
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role_select,
                'department_id' => $this->department_id,
                'phone_number' => $this->phone_number,
                'birthdate' => $this->birthdate,
                'salary' => $this->salary,
                'address' => $this->address,
            ]);

            $this->dispatch('close-modal', 'create-user-modal');
            Notification::make()
                ->title('User created successfully')
                ->success()
                ->send();
        }

        $this->reset(['userId', 'name', 'email', 'password', 'role_select', 'department_id', 'phone_number', 'birthdate', 'salary', 'address']);
    }

    // View user details
    public function viewUser($id)
    {
        $this->viewUserId = $id;
        $this->dispatch('open-modal', 'view-user-modal');
    }

    // Reset password
    public function confirmPasswordReset($id)
    {
        $this->resetPasswordId = $id;
        $this->newPassword = '';

        $this->dispatch('open-modal', 'reset-password-modal');
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:8',
        ]);

        try {
            $user = User::findOrFail($this->resetPasswordId);
            $user->update(['password' => Hash::make($this->newPassword)]);

            $this->dispatch('close-modal', 'reset-password-modal');
            Notification::make()
                ->title('Password reset successfully')
                ->success()
                ->send();
            $this->resetPasswordId = null;
            $this->newPassword = '';
        } catch (\Exception $e) {
            Notification::make()
                ->title('Failed to reset password')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // Delete user
    public function confirmUserDeletion($id)
    {
        $this->userIdBeingDeleted = $id;
        $this->dispatch('open-modal', 'delete-user-modal');
    }

    public function deleteUser()
    {
        try {
            $user = User::findOrFail($this->userIdBeingDeleted);
            $user->delete();

            $this->dispatch('close-modal', 'delete-user-modal');
            Notification::make()
                ->title('User deleted successfully')
                ->success()
                ->send();
            $this->userIdBeingDeleted = null;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Failed to delete user')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        $departmentsList = Department::all();
        $this->dispatch('refresh-preline');
        
        return view('livewire.director.users', [
            'departments' => $departmentsList,
            'roles' => ['staff', 'manager', 'admin', 'director'],
            'userBeingViewed' => $this->viewUserId ? User::findOrFail($this->viewUserId) : null,
        ])->layout('layouts.director', ['title' => 'Users Management']);
    }

    /**
     * Generate WhatsApp URL for user's phone number
     */
    private function getWhatsAppUrl($user)
    {
        if (empty($user->phone_number)) {
            return '#';
        }

        // Clean the phone number (remove non-numeric characters except +)
        $phoneNumber = preg_replace('/[^\d+]/', '', $user->phone_number);
        
        // Remove leading + if present for WhatsApp API
        $phoneNumber = ltrim($phoneNumber, '+');
        
        // If the number doesn't start with country code, assume Indonesian (+62)
        if (!preg_match('/^(62|1|44|33|49|81|86|91|55|52|54|56|57|58|51|53|506|507|508|509)/', $phoneNumber)) {
            // Remove leading 0 if present (common in Indonesian phone numbers)
            $phoneNumber = ltrim($phoneNumber, '0');
            $phoneNumber = '62' . $phoneNumber; // Indonesian country code
        }
        
        // Pre-filled message
        $message = urlencode("Hello {$user->name}, I'm contacting you from the company system.");
        
        return "https://wa.me/{$phoneNumber}?text={$message}";
    }
}