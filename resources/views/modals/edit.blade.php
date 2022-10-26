<!-- Edit Popup -->
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Add New Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
                <div class="mb-3">
                    <label for="name">title</label>
                    <input type="text" id="title" name="title" class="form-control editName" placeholder="Input title" required>
                </div>
                <div class="mb-3">
                    <label for="password">difficulty</label>
                    <input type="text" id="difficulty" name="difficulty" class="form-control editPassword" placeholder="Input difficulty" required>
                </div>
                <div class="mb-3">
                    <label for="point">reward</label>
                    <input type="number" id="reward" name="reward" class="form-control editPoint" placeholder="Input reward" required>
                </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="edittask" class="btn btn-primary modal_edit_button">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Popup End -->