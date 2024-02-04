<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script src="recorder.js"></script>
<script>
    $(document).ready(function(){
        URL = window.URL || window.webkitURL
        var gumStream, rec, input, AudioContext = window.AudioContext || window.webkitAudioContext
        var audioContext = new AudioContext
        var recordButton = document.getElementById("start_rec")
        var stopButton = document.getElementById("stop_rec")

        recordButton.addEventListener("click", startRecording)
        stopButton.addEventListener("click", stopRecording)

        function startRecording(){
            console.log("Record Button clicked")
            var constraints = {
                audio: true,
                video: false
            }

            recordButton.style.display = "none"
            stopButton.style.display = "block"

            navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
                console.log("getUserMedia() success, stream created, initializing Recorder.js ...")
                /* assign to gumStream for later use */
                gumStream = stream;
                /* use the stream */
                input = audioContext.createMediaStreamSource(stream);
                /* Create the Recorder object and configure to record mono sound (1 channel) Recording 2 channels will double the file size */
                rec = new Recorder(input, {
                    numChannels: 1
                })
                //start the recording process
                rec.record()
                console.log("Recording started");
            }).catch((error) => {
                console.error(error)
                recordButton.style.display = "block"
                stopButton.style.display = "none"
            })
        }

        function stopRecording(){
            console.log("Stop Button Clicked")
            stopButton.style.display = "none"
            recordButton.style.display = "block"

            rec.stop()
            gumStream.getAudioTracks()[0].stop()
            console.log(gumStream)
            rec.exportWAV(createDownloadLink)
        }

        function createDownloadLink(blob) {
            recordingsList = document.getElementById("recordingList")
            var url = URL.createObjectURL(blob);
            var au = document.createElement('audio');
            var li = document.createElement('li');
            var link = document.createElement('a');
            //add controls to the <audio> element
            au.controls = true;
            au.src = url;
            //link the a element to the blob
            link.href = url;
            link.download = new Date().toISOString() + '.wav';
            link.innerHTML = link.download;
            //add the new audio and a elements to the li element
            li.appendChild(au);
            li.appendChild(link);
            //add the li element to the ordered list
            recordingsList.appendChild(li);
        }
    })
</script>
