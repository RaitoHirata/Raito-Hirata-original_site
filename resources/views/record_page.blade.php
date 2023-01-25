
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Slow-High</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/base.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
        <script src="{{ asset('/js/layout.js') }}"></script>
        
    </head>
<body>
    <h1>How to record audio using Web Audio API in JavaScript</h1>
    <div>
      <button type="button" id="buttonStart">Start</button>
      <button type="button" id="buttonStop" disabled>Stop</button>
    </div>
    <div>
      <audio controls id="audio"></audio>
    </div>
    <script src="encode-audio.js"></script>
    <script src="main.js"></script>
  
<script>
class AudioRecorder extends AudioWorkletProcessor {
  static get parameterDescriptors () { // <1>
    return [
      {
        name: 'isRecording',
        defaultValue: 0,
        minValue: 0,
        maxValue: 1,
      },
    ]
  }

  process (inputs, outputs, parameters) {
    const buffer = []
    const channel = 0

    for (let t = 0; t < inputs[0][channel].length; t += 1) {
      if (parameters.isRecording[0] === 1) { // <2>
        buffer.push(inputs[0][channel][t])
      }
    }

    if (buffer.length >= 1) {
      this.port.postMessage({buffer}) // <3>
    }

    return true
  }
}

registerProcessor('audio-recorder', AudioRecorder) // <4>

function encodeAudio (buffers, settings) {
  const sampleCount = buffers.reduce((memo, buffer) => {
    return memo + buffer.length
  }, 0)

  const bytesPerSample = settings.sampleSize / 8
  const bitsPerByte = 8
  const dataLength = sampleCount * bytesPerSample
  const sampleRate = settings.sampleRate

  const arrayBuffer = new ArrayBuffer(44 + dataLength)
  const dataView = new DataView(arrayBuffer)

  dataView.setUint8(0, 'R'.charCodeAt(0)) // <10>
  dataView.setUint8(1, 'I'.charCodeAt(0))
  dataView.setUint8(2, 'F'.charCodeAt(0))
  dataView.setUint8(3, 'F'.charCodeAt(0))
  dataView.setUint32(4, 36 + dataLength, true)
  dataView.setUint8(8, 'W'.charCodeAt(0))
  dataView.setUint8(9, 'A'.charCodeAt(0))
  dataView.setUint8(10, 'V'.charCodeAt(0))
  dataView.setUint8(11, 'E'.charCodeAt(0))
  dataView.setUint8(12, 'f'.charCodeAt(0))
  dataView.setUint8(13, 'm'.charCodeAt(0))
  dataView.setUint8(14, 't'.charCodeAt(0))
  dataView.setUint8(15, ' '.charCodeAt(0))
  dataView.setUint32(16, 16, true)
  dataView.setUint16(20, 1, true)
  dataView.setUint16(22, 1, true)
  dataView.setUint32(24, sampleRate, true)
  dataView.setUint32(28, sampleRate * 2, true)
  dataView.setUint16(32, bytesPerSample, true)
  dataView.setUint16(34, bitsPerByte * bytesPerSample, true)
  dataView.setUint8(36, 'd'.charCodeAt(0))
  dataView.setUint8(37, 'a'.charCodeAt(0))
  dataView.setUint8(38, 't'.charCodeAt(0))
  dataView.setUint8(39, 'a'.charCodeAt(0))
  dataView.setUint32(40, dataLength, true)

  let index = 44

  for (const buffer of buffers) {
    for (const value of buffer) {
      dataView.setInt16(index, value * 0x7fff, true)
      index += 2
    }
  }

  return new Blob([dataView], {type: 'audio/wav'})
}
async function main () {
  try {
    const buttonStart = document.querySelector('#buttonStart')
    const buttonStop = document.querySelector('#buttonStop')
    const audio = document.querySelector('#audio')

    const stream = await navigator.mediaDevices.getUserMedia({ // <1>
      vide: false,
      audio: true,
    })

    const [track] = stream.getAudioTracks()
    const settings = track.getSettings() // <2>

    const audioContext = new AudioContext() 
    await audioContext.audioWorklet.addModule('audio-recorder.js') // <3>

    const mediaStreamSource = audioContext.createMediaStreamSource(stream) // <4>
    const audioRecorder = new AudioWorkletNode(audioContext, 'audio-recorder') // <5>
    const buffers = []

    audioRecorder.port.addEventListener('message', event => { // <6>
      buffers.push(event.data.buffer)
    })
    audioRecorder.port.start() // <7>

    mediaStreamSource.connect(audioRecorder) // <8>
    audioRecorder.connect(audioContext.destination)

    buttonStart.addEventListener('click', event => {
      buttonStart.setAttribute('disabled', 'disabled')
      buttonStop.removeAttribute('disabled')

      const parameter = audioRecorder.parameters.get('isRecording')
      parameter.setValueAtTime(1, audioContext.currentTime) // <9>

      buffers.splice(0, buffers.length)
    })

    buttonStop.addEventListener('click', event => {
      buttonStop.setAttribute('disabled', 'disabled')
      buttonStart.removeAttribute('disabled')

      const parameter = audioRecorder.parameters.get('isRecording')
      parameter.setValueAtTime(0, audioContext.currentTime) // <10>

      const blob = encodeAudio(buffers, settings) // <11>
      const url = URL.createObjectURL(blob)

      audio.src = url
    })
  } catch (err) {
    console.error(err)
  }
}

main()
/*
  new Vue ({
    el:'#app',
    data:{
      status: 'init',     // 状況
      recorder: null,     // 音声にアクセスする "MediaRecorder" のインスタンス
      audioData: [],      // 入力された音声データ
      audioExtension: ''  // 音声ファイルの拡張子
    },
    methods: {
      startRecording() {

      this.status = 'recording';
      this.audioData = [];
      this.recorder.start();

      },
      stopRecording() {

      this.recorder.stop();
      this.status = 'ready';

      },

    

    getExtension(audioType) {

      let extension = 'wav';
      const matches = audioType.match(/audio\/([^;]+)/);

      if(matches) {

          extension = matches[1];

      }

      return '.'+ extension;

    }
  },
    mounted() {

      navigator.mediaDevices.getUserMedia({ audio: true })
    .then(stream => {

        this.recorder = new MediaRecorder(stream);
        this.recorder.addEventListener('dataavailable', e => {

            this.audioData.push(e.data);
            this.audioExtension = this.getExtension(e.data.type);

        });
        this.recorder.addEventListener('stop', () => {

            const audioBlob = new Blob(this.audioData);
            const url = URL.createObjectURL(audioBlob);
            let a = document.createElement('a');
            a.href = url;
            a.download = Math.floor(Date.now() / 1000) + this.audioExtension;
            document.body.appendChild(a);
            a.click();

        });
        this.status = 'ready';

    });

    }
  });*/
</script>
</body>