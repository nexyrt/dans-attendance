<div class="max-w-6xl mx-auto py-6">
    <x-input.select
    name="department"
    :options="[
        ['value' => 1, 'label' => 'Digital Marketing'],
        ['value' => 2, 'label' => 'Sydital'],
        ['value' => 3, 'label' => 'Detax'],
        ['value' => 4, 'label' => 'HR'],
    ]"
    :selected="2"
    placeholder="Select department"
/>

    <p>{{$department}}</p>
</div>
