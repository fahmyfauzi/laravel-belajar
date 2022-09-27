<!DOCTYPE html>
<html lang="en">

<head>
    {{-- meta tags --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- bootrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    {{-- selec2 --}}
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.3.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <title>Laravel Raja Ongkir</title>
</head>

<body style="background: #f3f3f3">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3>ORIGIN</h3>
                        <hr>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">PROVINSI ASAL</label>
                            <select name="province_origin" id="" class="form-control">
                                <option value="0">-- pilih provinsi asal</option>
                                @foreach ($provinces as $province => $value)
                                <option value="{{ $province }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">KOTA / KABUPATEN ASAL</label>
                            <select name="city_origin" id="" class="form-control kota-asal">
                                <option value="">-- pilih provinsi asal</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3>DESTINATION</h3>
                        <hr>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">PROVINSI TUJUAN</label>
                            <select name="province_destination" id="" class="form-control provinsi-tujuan">
                                <option value="0">-- pilih provinsi asal</option>
                                @foreach ($provinces as $province => $value)
                                <option value="{{ $province }}">{{$value}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">KOTA / KABUPATE TUJUAN</label>
                            <select name="city_destination" id="" class="form-control kota-tujuan">
                                <option value="">-- pilih kota tujuan --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3>KURIR</h3>
                        <hr>
                        <div class="form-group">
                            <label for="">PROVINSI TUJUAN</label>
                            <select name="courier" id="" class="form-control kurir">
                                <option value="">-- pilih kurir --</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">BERAT (GRAM)</label>
                            <input type="number" name="weight" id="weight" placeholder="Masukan Berat (GRAM)"
                                class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-md btn-primary btn-block btn-check">CEK ONGKOS KIRIM</button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card d-none ongkir">
                    <div class="card-body">
                        <ul class="list-group" id="ongkir"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


    <script>
        // code
        $(document).ready(function(){
            //select2
            $('.provinsi-asal','.kota-asal','.provinsi-tujuan','.kota-tujuan').select2({
                theme:'bootstrap4',
                width:'style',
            });

            //ajax select kota asal
            $('select[name="province_origin"]').on('change',function(){
                let provinceId = $(this).val();
                if(provinceId){
                    jQuery.ajax({
                    url: '/cities/'+provinceId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                    $('select[name="city_origin"]').empty();
                    $('select[name="city_origin"]').append('<option value="">-- pilih kota asal --</option>');
                    $.each(response, function (key, value) {
                    $('select[name="city_origin"]').append('<option value="' + key + '">' + value + '</option>');
                    });
                    },
                    });
                }else{
                    $('select[name="city_origin"]').append(`
                        <option value="">-- pilih kota asal --</option>
                    `);
                }
            });

            //ajax select kota tujuan
            $('select[name="province_destination"]').on('change', function(){
                let provinceId = $(this).val();

                if(provinceId){
                    jQuery.ajax({
                        url: `/cities/${provinceId}`,
                        type:'get',
                        dataType:'json',
                        success:function(response){
                            $('select[name="city_destination"]').empty();
                            $('select[name="city_destination"]').append(`
                                <option value="">-- pilih kota tujuan --</option>
                            `);
                           $.each(response, function (key, value) {
                            $('select[name="city_destination"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                }else{
                    $('select[name="city_destination"]').append(`
                        <option value="">-- pilih kota tujuan --</option>
                    `);
                }
            });

            //ajax chek ongkir

            let isProcessing = false;
            $('.btn-check').click(function(e){
                e.preventDefault();

                let token =$("meta[name='csrf-token']").attr("content");
                let city_origin = $('select[name="city_origin"]').val();
                let city_destination = $('select[name="city_destination"]').val();
                let courier = $('select[name="courier"]').val();
                let weight = $('#weight').val();

                if(isProcessing){
                    return;
                }
                isProcessing = true;
                jQuery.ajax({
                    url:'/ongkir',
                    data:{
                        _token : token,
                        city_origin: city_origin,
                        city_destination: city_destination,
                        courier : courier,
                        weight: weight
                    },
                    dataType:'json',
                    type:'post',
                    success:function(response){
                        isProcessing = false;
                        if(response){
                            $('#ongkir').empty();
                            $('.ongkir').removeClass('d-none');
                            $('.ongkir').addClass('d-block');
                            $.each(response[0]['costs'],function(key, value){
                                $('#ongkir').append(`
                                    <li class="list-group-item">${response[0].code.toUpperCase()} : <strong>${value.service} </strong> - Rp. ${value.cost[0].value} ${value.cost[0].etd} hari</li>
                                `);
                            })
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>