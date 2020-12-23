<div>
    <div class="d-flex justify-content-end mb-1">
        <div class="btn-group" data-toggle="buttons">
            <form action="{{route('user.setShowCards')}}" method="POST">
                @csrf
                @method('PUT')
                <button class="btn {{Helper::showCards()=='true' ? 'btn-primary' : 'btn-outline-primary'}} btn-sm" type="submit" name="showCards" value="true"  ><i class="fa fa-bars"></i></button>
                <button class="btn {{Helper::showCards()=='false' ? 'btn-primary' : 'btn-outline-primary'}} btn-sm" type="submit" name="showCards" value="false"   ><i class="fa fa-table"></i></button>
            </form>
        </div>
    </div>
</div>
