<li id="home" class="">
    <a href="{{ URL::to('home') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Dashboard</span>
    </a>
</li>
@permission('kategori-list')
<li id="kategori" class="">
    <a href="{{ URL::to('master/kategori') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Kategori</span>
    </a>
</li>
@endpermission

@permission('satuan-list')
<li id="satuan" class="">
    <a href="{{ URL::to('master/satuan') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Satuan</span>
    </a>
</li>
@endpermission

@permission('bahan-list')
<li id="bahan" class="">
    <a href="{{ URL::to('master/bahan') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Bahan</span>
    </a>
</li>
@endpermission

@permission('resep-list')
<li id="resep" class="">
    <a href="{{ URL::to('master/resep') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Resep</span>
    </a>
</li>
@endpermission

@role('admin')
<li id="role" class="">
    <a href="{{ URL::to('role') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Role</span>
    </a>
</li>

<li id="permission" class="">
    <a href="{{ URL::to('permission') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>Permission</span>
    </a>
</li>

<li id="user" class="">
    <a href="{{ URL::to('user') }}" >
    <i class="fa fa-fw fa-th "></i>
    <span>User</span>
    </a>
</li>
@endrole

@push('js')
<script type="text/javascript">
$(document).ready(function(){

})

$('ul.sidebar-menu li').on('click',function() {
    $(this).parent().find('li.active').removeClass('active');
    // $(this).addClass('active');
    localStorage.setItem('lastActiveId', $(this).attr('id')); 
});

$(function () {
    var lastId = localStorage.getItem('lastActiveId', $(this).attr('id'));
    //check if defined
    if(!!lastId)
    {
        $('#' + lastId).addClass('active');      
    }
});


</script>
@endpush

