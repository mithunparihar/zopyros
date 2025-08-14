<ul class="dropdown-menu countrylist">
    <li><input type="text" class="form-control SearchConCode" placeholder="Search Country Code">
    </li>
    @foreach ($lists as $list)
        <li onclick="Livewire.dispatch('updateCcode',{ccode:{{ $list->phonecode }},flag:'{{ strtolower($list->sortname) }}' })"
            data-code="{{ strtolower($list->sortname) }}" data-name="{{ $list->name }}"
            data-text="+{{ $list->phonecode }}"><i
                class="flagicon fi-{{ strtolower($list->sortname) }}"></i>{{ $list->name }}
            <span>(+{{ $list->phonecode }})</span>
        </li>
    @endforeach
</ul>