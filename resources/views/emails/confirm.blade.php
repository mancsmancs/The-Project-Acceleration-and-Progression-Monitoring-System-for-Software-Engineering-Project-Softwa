@extends('emails.layout')

@section('content')
คุณ {{ $first_name }} โปรดยืนยันการสมัคร โดยคลิกลิ้งดังต่อไปนี้

<a href="{{ route('activate',['id'=>$id,'hash'=>$comfirmcode]) }}" >ยืนยันตัวเอง</a>

@stop