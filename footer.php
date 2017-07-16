        </div>
    </div>
    <script type="text/javascript">
        var _canvas = document.getElementById('myCanvas');
        _canvas.width = window.screen.width;
        _canvas.height = window.screen.width;
        _canvas.style.backgroundColor = '#301B56';

        var _ctx = _canvas.getContext('2d');
        // 绘制波纹
        var xPoint = _canvas.width / 2;
        var yPoint = -50;

        _ctx.beginPath();
        _ctx.strokeStyle = '#2d526f';
        _ctx.arc(xPoint, yPoint, 100, 0, Math.PI, false);
        _ctx.stroke();

        _ctx.arc(xPoint, yPoint, 105, 0, Math.PI, false);
        _ctx.stroke();
    </script>
    <?php wp_footer(); ?>
</body>
</html>