<style>
    @page { margin: 0mm; }
    body { margin: 0mm; }
    #qrcode{
        width    : 20mm;
        height   : 20mm;
    }
     
</style>

@foreach($checked as $id)
    <?php
        $asset = \App\Asset::where('id',$id)->first();
    ?>
    <body>
        <div align="center">
            <?php 
                $get_type = $asset->codeType->code_name ?? '--';
                $get_class = $asset->assetClass->class_code ?? '--';
                $get_department = $asset->type->department->department_name ?? '--';
                $get_asset = $asset->asset_code ?? '--';
                $get_code = $get_type.'/'.$get_class.'/'.$get_department.'/'.$get_asset;
            ?>
            <img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="40" width="120" alt="INTEC"><br>
            <img id="qrcode" src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->generate($get_code)) !!}"><br>
            <p style="font-size: 3.70mm; font-weight: 500">
                {{ $get_code }}
            </p>
        </div>
    </body>
@endforeach