@extends('layouts.apps')

@section('content')
<style>
* {
    margin: 0;
    padding: 0;
    font-family: "Open Sans", sans-serif;
    box-sizing: border-box;
}

body,
html {
    align-items: center;
    justify-content: center;
    background-color: #f1f1f1;
}

.about-section {
    background-color: #474e5d;
    overflow: hidden;
    padding: 100px 0;
}

.inner-container {
    background-color: #fdfdfd;
    padding: 120px 80px;
}

.about-section img {
    -webkit-filter: drop-shadow(5px 5px 5px #2B2B2B);
    filter: drop-shadow(5px 5px 10px #2B2B2B);
}

.inner-container h1 {
    margin-bottom: 30px;
    font-size: 30px;
    font-weight: 900;
}

.text {
    font-size: 13px;
    color: #545454;
    line-height: 30px;
    text-align: justify;
    margin-bottom: 40px;
}

.skills {
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    font-size: 13px;
}

@media screen and (max-width:1200px) {
    .inner-container {
        padding: 80px;
    }
}

@media screen and (max-width:1000px) {
    .about-section {
        background-size: 100%;
        padding: 100px 40px;
    }

    .inner-container {
        width: 100%;
    }
}

@media screen and (max-width:600px) {
    .about-section {
        padding: 0;
    }

    .inner-container {
        padding: 60px;
    }
}
</style>
<div class="about-section d-flex justify-content-between">
    <div class="another w-50 my-auto">

        <img src="assets/image/logo.png" alt="" class="">
    </div>
    <div class="inner-container w-50 shadow">
        <h1>About Us</h1>
        <p class="text">
            CrownShop adalah toko pakaian yang menyediakan berbagai merk baju yang kekinian.CrownShop juga menyediakan
            berbagai jenis fashion pria/wanita yang bisa dipilih sesuai selera,kami juga menyediakan produk berkualitas
            tebaik untuk pria dan wanita,bervariasi dari pakaian, aksesori, sepatu, tas, produk olahraga dan kecantikan.
            Komitmen kami adalah memberikan pengalaman belanja online yang menyenangkan, mudah, dan terpercaya untuk
            memuaskan pelanggan dengan koleksi baru dan penawaran spesial setiap harinya, serta beragam keuntungan
            seperti kemudahan pengembalian produk hingga 14 hari setelah barang diterima, layanan pembelian datang
            langsung ke outlet kita terdekat.
        </p>
        <div class="skills">
            <span>Contact us</span>
        </div>
    </div>
</div>
@endsection