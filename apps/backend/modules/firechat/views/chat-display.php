
<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<!-- Download from https://github.com/firebase/Firechat -->
<link rel="stylesheet" href="/apps/backend/modules/firechat/assets/firechat-default.css" />
<script src="/apps/backend/modules/firechat/assets/firechat-default.js"></script>
<style>
    #firechat-wrapper {
        height: 500px;
        max-width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #fff;
        margin: 50px auto;
        text-align: center;
    }
</style>

<div id="firechat-wrapper"></div>
<script type='text/javascript'>
    var person_id = <?= $person->id; ?>;
    var uname = '<?= $person_lang->first_name; ?> <?= $person_lang->last_name; ?>';

        var chatRef = new Firebase('https://aplchat.firebaseio.com');
        var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));

        chatRef.auth('<?= $token; ?>', function(error, user) {
            if (error) {
                alert("Login Failed!");
            } else {
                console.log("Login Succeeded!", user, user.auth.id);

                chat.setUser(user.auth.uid, uname);

                setInterval(function() {
                    chat._chat.getRoomList(function(list) {
                        for (var roomId in list) {
                            if (list[roomId].person_id == person_id && list[roomId].closed == 0) {
                                chat._chat.enterRoom(roomId);
                            }
                        }
                    });
                }, 2000);
            }
        });

        chat._chat.on('room-exit', function(roomId) {
            (new Firebase('https://aplchat.firebaseio.com/room-metadata/' + roomId)).child('closed').set(1);
            jQuery.post('<?= url('firechat/closeroom'); ?>', {roomId: roomId, person_id: '<?= $person->id; ?>'});
        });
</script>