<script>
    $(document).ready(function(){
        const recordButton = document.getElementById("start_rec")
        const stopButton = document.getElementById("stop_rec")

        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia){
            console.log("getusermedia suported")
            navigator.mediaDevices.getUserMedia({audio:true}).then((stream) => {
                const mediaRecorder = new MediaRecorder(stream)

                recordButton.onclick = function(){
                    if($("#recordingList").children().length > 0){
                        console.log("Still left")
                        return
                    }
                    if(mediaRecorder.state != "recording"){
                        mediaRecorder.start()
                    }
                    console.log(mediaRecorder.state)
                    recordButton.style.display = "none"
                    stopButton.style.display = "block"
                    console.log("Recording Started")
                }
                let audioChunks = []
                mediaRecorder.ondataavailable = function(e){
                    audioChunks.push(e.data)
                }

                stopButton.onclick = function(){
                    mediaRecorder.stop()
                    console.log(mediaRecorder.state)
                    stopButton.style.display = "none"
                    recordButton.style.display = "block"
                    console.log("Recording Stopped")
                }

                mediaRecorder.onstop = function(e) {
                    console.log("recorder stopped")
                    var downloaded = false
                    var soundClips = document.getElementById("recordingList")
                    mediaRecorder.stream.getTracks().forEach(track => track.stop())
                    const clipName = prompt('Enter a name for your sound clip');

                    const blob = new Blob(audioChunks, { 'type' : 'audio/mp3; codecs=opus' });
                    audioChunks = [];
                    const audioURL = window.URL.createObjectURL(blob);

                    $("#add_new_box").modal("hide")
                    $("#recordingList").append(`<tr>
                        <td>${clipName}</td>
                        <td class="recordActions">
                            <button class='play btn btn-primary'>
                                <i class="fa fa-play fa-2x"></i>
                            </button>
                            <button class='deleteAudio btn btn-danger'>
                                <i class="fa fa-trash fa-2x"></i>
                            </button>
                            <a href="${audioURL}" download="${clipName}.mp3" class="btn btn-success downloader">
                                <i class="fa fa-download fa-2x"></i>
                            </a>
                        </td>
                    </tr>`);

                    document.getElementsByClassName("play")[0].addEventListener("click", () => {
                        let audioPlayer = document.createElement("audio")
                        audioPlayer.src = audioURL
                        audioPlayer.play()
                    })

                    $(".deleteAudio").click(function(){
                        //$("#recordingList").html("")
                        if(!downloaded){
                            var confirm = window.confirm("You haven't downloaded the audio yet.")
                            if(confirm){
                                $(this).closest("tr").remove()
                            }
                        }
                    })

                    // const deleteButton = document.getElementsByClassName('deleteAudio')[0]
                    //
                    // deleteButton.onclick = function(e) {
                    //     let evtTgt = e.target;
                    //     evtTgt.parentNode.parentNode.removeChild(evtTgt.parentNode);
                    // }
                }
            }).catch((error) => {
                console.error(error)
            })
        }else{
            console.loog("Get User Media not supported")
        }

        $(document).on("click", ".downloader", function(){
            downloaded = true
        })
    })
</script>
