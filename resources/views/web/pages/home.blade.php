@extends('web.layout.master')

@section('body')
<div class="container">
    <h2>Tambah Penandatangan untuk Perusahaan</h2>
    @foreach($perusahaan as $a)
        <h3>{{ $a->nama_perusahaan }}</h3>
        @foreach($a->penandatangan as $list)
            <h3>{{ $list->nama_penandatangan }}</h3>
            <img src="{{ asset('signatures/' . $list->signature) }}" alt="Tanda Tangan" />
        @endforeach
    @endforeach

    @foreach($perusahaan as $index => $list)
    <h3>{{ $list->nama_perusahaan }}</h3>
    <form action="{{ route('penantangan.store') }}" method="POST" enctype="multipart/form-data" id="form-{{ $index }}">
        @csrf
        <input type="hidden" name="perusahaan_id" value="{{ $list->id }}">
        <div class="form-group">
            <label for="nama_penandatangan_{{ $index }}">Nama Penandatangan:</label>
            <input type="text" class="form-control" id="nama_penandatangan_{{ $index }}" name="nama_penandatangan" required>
        </div>
        <div class="form-group">
            <label for="signature_pad_{{ $index }}">Tanda Tangan:</label>
            <br>
            <canvas id="signature-pad-{{ $index }}" width="400" height="200" style="border:1px solid #111;"></canvas>
            <input type="hidden" id="signature_{{ $index }}" name="signature">
            <button type="button" id="clear_{{ $index }}" class="btn btn-danger">Hapus</button>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    @endforeach
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Function to handle the drawing
        function setupSignaturePad(index) {
            var canvas = document.getElementById('signature-pad-' + index);
            var ctx = canvas.getContext('2d');
            var drawing = false;
            var lastX = 0;
            var lastY = 0;

            function draw(e) {
                if (!drawing) return;

                var offsetX = e.offsetX || e.touches[0].clientX - canvas.offsetLeft;
                var offsetY = e.offsetY || e.touches[0].clientY - canvas.offsetTop;

                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(offsetX, offsetY);
                ctx.stroke();

                lastX = offsetX;
                lastY = offsetY;
            }

            canvas.addEventListener('mousedown', (e) => {
                drawing = true;
                lastX = e.offsetX;
                lastY = e.offsetY;
            });

            canvas.addEventListener('touchstart', (e) => {
                drawing = true;
                lastX = e.touches[0].clientX - canvas.offsetLeft;
                lastY = e.touches[0].clientY - canvas.offsetTop;
            });

            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('touchmove', draw);
            canvas.addEventListener('mouseup', () => drawing = false);
            canvas.addEventListener('touchend', () => drawing = false);
            canvas.addEventListener('mouseout', () => drawing = false);
            canvas.addEventListener('touchcancel', () => drawing = false);

            document.getElementById('clear_' + index).addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('signature_' + index).value = "";
            });

            document.getElementById('form-' + index).addEventListener('submit', function(e) {
                var signature = canvas.toDataURL('image/png');
                document.getElementById('signature_' + index).value = signature;
            });
        }

        // Setup each signature pad
        @foreach($perusahaan as $index => $list)
            setupSignaturePad({{ $index }});
        @endforeach
    });
</script>
@endsection
