{{-- Selector de autor (solo en el panel de administración) --}}
<div class="mt-5">
    <x-input-label for="user_id" value="Autor *" />
    <select id="user_id" name="user_id" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-marca-500 focus:ring-marca-500">
        @foreach ($usuarios as $u)
            <option value="{{ $u->id }}" @selected(old('user_id', $conocimiento->user_id) == $u->id)>{{ $u->name }} — {{ $u->area }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
</div>
