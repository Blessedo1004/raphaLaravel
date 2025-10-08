<x-head-two title="Verify Email" description="zzzzzz">
    <x-slot name="body">
     <img src="https://raphahotel.ng/images/logo-white1.webp" alt="logo">
    <p style="text-align:center">Hello. Your email verification code is {{$code}}</p>
    {{-- <p class="text-center"><a href=""><input type="button" style="background-color: #ab8965; color:white; padding: 10px 20px; border-radius: 5px;" value="Verify Email"></a></p> --}}
    
    <p style="text-align:center">This code is scheduled to be invalid in 20 minutes.</p>
    <p style="text-align:center">If this wasn't you or you didn't request for this code, please kindly ignore this email.</p>
    </x-slot>
    
</x-head-two>