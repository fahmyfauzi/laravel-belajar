@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <!-- Form -->
            <div class="my-3">
                <h2 class="text-center">Cek Resi</h2>
                <p class="text-center text-mute">Silahkan Cek Resi Anda...</p>
            </div>
            <div class="form-group">

                <input type="text" id="no-resi" class="form-control mb-3" placeholder="Masukan No Resi Anda">

                <select class="mb-3 form-control" id="jasa-pengiriman">
                    <option value="">Pilih salah satu..</option>
                    <option value="jne">JNE</option>
                    <option value="jnt">JNT</option>
                    <option value="pos">POS</option>
                    <option value="sicepat">SICEPAT</option>
                    <option value="tiki">TIKI</option>
                    <option value="anteraja">ANTER AJA</option>
                    <option value="wahana">WAHANA</option>
                    <option value="ninja">NINJA</option>
                    <option value="lion">LION</option>
                    <option value="ide">ID EXPRESS</option>
                    <option value="spx">SHOPEE EXPRESS</option>
                </select>

            </div>

            <button id="btn-cek" class="btn btn-primary">CEK</button>
            <button id="btn-reset" class="btn btn-dark">RESET</button>
            <!-- akhir form -->
        </div>

        <div class="mt-3">
            <div class="container mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-8" id="hasil-pencarian">

                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8" id="history-pengiriman">

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

@push('scripts')

{{-- jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    //cek-resi
    $(document).ready(function(){

   
        $('#btn-cek').click(function(e){
            e.preventDefault();     
            //ajax            
            $.ajax({
                 url: 'https://api.binderbyte.com/v1/track',
                type: 'get',
                dataType: 'json',
                data: {         
                'api_key': '81e8dd31e2562047de70e36b5d5bd1049458893c1b13470091aee47faeab25cb',
                //ambil data inputan
                'courier': $('#jasa-pengiriman').val(),
                'awb': $('#no-resi').val()
            },
              success: function(result){
                    if(result.status = "200"){
                        //fetch
                        let resi = result.data;

                        console.log(resi);

                        $('#hasil-pencarian').html(`
                            <table class="table table-striped">
                           <tbody>
                                <tr>
                                    <td>Nomor Resi</th>
                                    <td>${resi.summary.awb} </td>
                                </tr>
                                <tr>
                                    <td>Jasa Pengiriman</th>
                                    <td>${resi.summary.courier }</td>
                                </tr>
                                <tr>
                                    <td>Jenis Servis</th>
                                    <td>${resi.summary.service }</td>
                                </tr>
                                <tr>
                                    <td>Status Pengiriman</th>
                                    <td>${resi.summary.status }</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Terima</th>
                                    <td>${resi.summary.date }</td>
                                </tr>
                            </tbody>
                            </table>

                        `);

                        $.each(resi.history,function(i,item){

                            $('#history-pengiriman').append(`
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">${item.date}</h5>
                                    <h5 class="card-text">${item.desc}</h5>
                                    <h5 class="card-text">${item.location}</h5>
                                </div>
                            </div>
                            `);
                        })
                        

                    }else{
                        $('#hasil-pencarian').html(`
                            <h4>${result.message}</h4>
                        `);
                    }
                },
                error:function(error)
                {
               
                    console.log(error)
             }
            });
        });

        // reset
        $('#btn-reset').on('click',function(){
            $('#jasa-pengiriman').val('');
            $('#no-resi').val('');
            $('#hasil-pencarian').hide();
            $('#history-pengiriman').hide();
        });


        
})
</script>
@endpush