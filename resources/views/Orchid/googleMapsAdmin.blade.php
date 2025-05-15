@if($coordinates)
    <form method="POST" action="{{ route('platform.maps.edit') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <div class="jsGMap3_SetMarker" id="MapShowMarker" data-zoom="10" data-lat="{{$coordinates->lat}}" data-lng="{{$coordinates->lng}}"
            style="border: 2px solid green; min-width: 300px; min-height: 400px">
        </div>

        <input type="hidden" class="jsGMap3_Marker"  name="lat" id="MapShowMarker_lat" data-title="marker-1" value="{{$coordinates->lat}}" />
        <input type="hidden" class="jsGMap3_Marker"  name="lng" id="MapShowMarker_lng" data-title="marker-2" value="{{$coordinates->lng}}" />
    </form>
@endif