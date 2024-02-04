<script type="text/javascript">
    $(document).ready(function(){
        const recordButton = document.getElementById("start_rec")
        const stopButton = document.getElementById("stop_rec")
        const addButton = document.getElementsByClassName("btn-add")[0]
        var audioURL = null

        addButton.onclick = () => {
            if($("#recordingList").children().length > 0){
                var confirm = window.confirm("You can record only one audio at a time. Do you want to delete previous one?")
                if(confirm){
                    deleteAudio()
                    $("#add_new_box").modal("show")
                }else{
                    return
                }
            }else{
                $("#add_new_box").modal("show")
            }
        }
        recordButton.onclick = () => {
            startAudioRecording()
        }
        stopButton.onclick = () => {
            stopAudioRecording()
        }
        function startAudioRecording(){
            audioRecorder.start().then(() => {
                console.log("Recording Audio")
                recordButton.style.display = "none"
                stopButton.style.display = "block"
            }).catch((error) => {
                console.error(error)
            })
        }
        function stopAudioRecording(){
            audioRecorder.stop().then((audioAsBlob) => {
                console.log("Recording Stopped with:", audioAsBlob)
                const clipName = prompt('Enter a name for your sound clip');
                audioURL = window.URL.createObjectURL(audioAsBlob);
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
                stopButton.style.display = "none"
                recordButton.style.display = "block"
            }).catch((error) => {
                console.error(error)
            })
        }

        var audioRecorder = {
            audioBlobs: [],
            mediaRecorder: null,
            streamBeingCaptured: null,
            start: function(){
                if(!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)){
                    return Promise.reject(new Error('Media Not supported'))
                }else{
                    return navigator.mediaDevices.getUserMedia({audio:true}).then((stream) => {
                        audioRecorder.streamBeingCaptured = stream
                        audioRecorder.mediaRecorder = new MediaRecorder(stream)
                        audioRecorder.audioBlobs = []
                        audioRecorder.mediaRecorder.addEventListener("dataavailable", (event) => {
                            audioRecorder.audioBlobs.push(event.data)
                        })
                        audioRecorder.mediaRecorder.start()
                    })
                }
            },
            stop: function(){
                return new Promise((resolve) => {
                    let mimeType = audioRecorder.mediaRecorder.mimeType
                    audioRecorder.mediaRecorder.addEventListener("stop", () => {
                        let audioBlob = new Blob(audioRecorder.audioBlobs, { 'type' : 'audio/mp3; codecs=opus' })
                        resolve(audioBlob)
                    })
                    audioRecorder.mediaRecorder.stop()
                    audioRecorder.stopStream()
                    audioRecorder.resetRecordingProperties()
                })
            },
            stopStream: function(){
                audioRecorder.streamBeingCaptured.getTracks().forEach(track => track.stop())
            },
            resetRecordingProperties: function(){
                audioRecorder.mediaRecorder = null
                audioRecorder.streamBeingCaptured = null
            },
            cancel: function(){

            }
        }

        $(document).on("click", ".play", function(){
            let audioPlayer = document.createElement("audio")
            audioPlayer.src = audioURL
            audioPlayer.play()
        })

        $(document).on("click", ".deleteAudio", function(){
            $(this).closest("tr").remove()
        })
        function deleteAudio(){
            $("#recordingList").html("")
        }
    })
</script>
