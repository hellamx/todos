@if ($errors->any())
    <div class="alert alert-danger border-0 mt-4">
        <ul style="list-style-type: none;" class="mb-0 ps-0">
            @foreach ($errors->all() as $error)
                <li style="color: #dc3545">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session()->exists('success'))
    <div class="alert alert-success mt-4 border-0">{{ session('success') }}</div>
@endif