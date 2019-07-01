<div id="qrCode" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: center">
                <div id="qrcode" style="width:256px;margin:0 auto;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="credentialsMod" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Credentials</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tbody id="credentials"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="delete" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This user will be deleted and it cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary btn-success" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="suspend" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="userData" style="display: none;"></div>
                <div id="serverData" style="display: none;"></div>
                This user will be suspended and will not be able to use this service. Of course, you can restore the user later.
            </div>
            <div class="modal-footer">
                <button type="button" id="suspendButton" class="btn btn-primary btn-danger" onclick="processSuspend()">Suspend</button>
                <button type="button" class="btn btn-secondary btn-success" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="restore" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="userData" style="display: none;"></div>
                <div id="serverData" style="display: none;"></div>
                This user will be restored and will be able to use this service. Of course, you can suspend the user again (if needed).
            </div>
            <div class="modal-footer">
                <button type="button" id="restoreButton" class="btn btn-primary btn-danger" onclick="processRestoreUser()">Restore</button>
                <button type="button" class="btn btn-secondary btn-success" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="sslink" class="modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SS Link</h5>
                <button type="button" class="close bclose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="sslink bg-dark text-white" style="word-break:break-word;padding:15px;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="copyToClipboard(this.innerText = 'Copied')" id="copy" class="btn btn-primary btn-success copy">Copy to clipboard</button>
                <button type="button" class="btn btn-secondary btn-danger bclose" data-dismiss="modal">Cancel</button>
            </div>
            <script>
                function copyToClipboard() {
                    const el = document.createElement('textarea');
                    el.value = document.querySelector('.sslink').innerText;
                    document.getElementById('copy').appendChild(el);
                    el.select();
                    document.execCommand('Copy');
                    document.getElementById('copy').removeChild(el);
                }
            </script>
        </div>
    </div>
</div>
<?php include_once __DIR__."/../views/user_and_server.php"; ?>