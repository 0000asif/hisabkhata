<!-- Withdraw Button -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#withdrawModal">
    Withdraw
</button>
<!-- Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('fd.withdraw', $fd->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">FD Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="withdraw_type">Withdraw Type:</label>
                    <select name="withdraw_type" id="withdraw_type" class="form-control" required>
                        <option value="mature">Mature Withdraw</option>
                        <option value="early">Early Withdraw (Penalty)</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm Withdraw</button>
                </div>
            </div>
        </form>
    </div>
</div>
