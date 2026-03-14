<?php

use Illuminate\Support\Facades\Broadcast;

// Tidak ada otentikasi PrivateChannel (Broadcast::channel(...)) di sini. 
// Karena notifikasi admin-orders dan order.{orderCode} menggunakan Public Channel 
// (class `Channel` biasa, bukan `PrivateChannel`) sehingga dapat di-listen oleh Guest di HP tanpa diblokir Auth Guard.