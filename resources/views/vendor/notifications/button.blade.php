@props([
    'url',
    'color' => 'primary',
])

<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:30px auto; text-align:center;">
<tr>
<td align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<a href="{{ $url }}"
   style="display:inline-block; background-color:#2563eb; color:#ffffff; text-decoration:none; font-weight:700; font-size:14px; padding:14px 28px; border-radius:10px;">
    {{ $slot }}
</a>
</td>
</tr>
</table>
</td>
</tr>
</table>