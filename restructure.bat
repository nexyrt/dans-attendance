@echo off
echo Creating new directory structure...

:: Buat direktori utama
cd resources\views
mkdir admin\dashboard
mkdir admin\users
mkdir admin\settings

mkdir manager\dashboard
mkdir manager\team
mkdir manager\reports

mkdir staff\dashboard
mkdir staff\attendance
mkdir staff\profile

mkdir components\layouts
mkdir components\navigation
mkdir components\shared

mkdir livewire\admin
mkdir livewire\manager
mkdir livewire\staff
mkdir livewire\shared\profile
mkdir livewire\shared\dashboard

:: Pindahkan file-file yang ada
echo Moving existing files...

:: Admin files
IF EXIST admin\schedule\index.blade.php (
    move admin\schedule\index.blade.php admin\dashboard\
)
IF EXIST admin\schedule\user.blade.php (
    move admin\schedule\user.blade.php admin\users\index.blade.php
)

:: Component files
IF EXIST components\layouts\admin.blade.php (
    move components\layouts\admin.blade.php components\layouts\
)
IF EXIST components\layouts\staff.blade.php (
    move components\layouts\staff.blade.php components\layouts\
)

:: Move button components
IF EXIST components\buttons\*.blade.php (
    move components\buttons\*.blade.php components\shared\
)

:: Move input components
IF EXIST components\input\*.blade.php (
    move components\input\*.blade.php components\shared\
)

:: Livewire files
IF EXIST livewire\admin\attendance-table.blade.php (
    move livewire\admin\attendance-table.blade.php livewire\admin\
)
IF EXIST livewire\admin\user-table.blade.php (
    move livewire\admin\user-table.blade.php livewire\admin\user-management.blade.php
)
IF EXIST livewire\profile\partials\edit.blade.php (
    move livewire\profile\partials\edit.blade.php livewire\shared\profile\
)

echo Structure reorganization completed!
pause