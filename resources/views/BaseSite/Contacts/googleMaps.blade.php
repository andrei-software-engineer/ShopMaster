<div class="content section-map">
    <div class="jsGMap3_ShowMarkers map-contacts"  data-zoom="{{$mapZoom}}" data-lat="{{$mapLat}}" data-lng="{{$mapLng}}">
        @if(count($objects))
            @foreach($objects as $item)
                <input 
                    type="hidden" 
                    class="jsGMap3_Marker" 
                    data-lat="{{$item->lat}}" 
                    data-lng={{$item->lng}} 
                    @if ($item->_title) data-title="{{$item->_title}}"  @endif
                    @if ($item->iconpath) data-iconpath="{{$item->iconpath}}"  @endif
                    @if ($item->cluster) data-cluster="{{$item->cluster}}"  @endif
                    @if ($item->dburl) data-dburl="{{$item->dburl}}"  @endif
                    @if ($item->infowindow) data-infowindow="{{$item->infowindow}}"  @endif 
                >
            @endforeach
        @endif
    </div>
</div>