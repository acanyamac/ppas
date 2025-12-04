<div class="modal fade custom-modal" id="updatefilenamemodal" tabindex="-1" role="dialog" aria-labelledby="updatefilenamemodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Doküman İsmi Güncelle</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                <div class="card-body">
                    <form>
                        @csrf
                        <input type="hidden" id="form_name_id" name="form_name_id" class="form-control">
                        <input type="hidden" id="page" name="page" class="form-control">
                        <input type="hidden" id="shownumber" name="shownumber" class="form-control">
                        <input type="hidden" id="file_category_id" name="file_category_id" class="form-control">
                        <input type="hidden" id="search" name="search" class="form-control">
                        <div class="form-group">
                            <label>Doküman İsmi</label>
                            <input type="text" id="form_name" name="form_name" class="form-control">
                            <div id="err" style="color:red;padding:5px;"></div>
                        </div>
                            <button type="button" class="btn btn-primary" onclick="update_filename($('#page').val(),$('#shownumber').val(),$('#file_category_id').val(),$('#search').val(),$('#form_name_id').val(),$('#form_name').val())">Güncelle</button>
                    </form>

                </div>

            </div>





        </div>
    </div>
</div>