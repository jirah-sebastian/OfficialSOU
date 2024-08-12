@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://clsu.edu.ph/public/assets/img/general/logo-white.png" class="logo" alt="SOIS Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
