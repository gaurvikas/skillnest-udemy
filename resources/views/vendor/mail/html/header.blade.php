@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'SkillNest')
<img src="{{ url('logo-dark.png') }}" class="logo h-12" alt="SkillNest">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
