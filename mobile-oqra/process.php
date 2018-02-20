<?php
$ffmpeg = '/usr/bin/ffmpeg';
$mov = glob('/home/fluohead/public_html/mobile-oqra/uploads/*.m4a', GLOB_BRACE);
if (count($mov) > 0) {
    foreach ($mov as $movie) {
        if (file_exists('/home/fluohead/public_html/mobile-oqra/done/' . basename($movie) . '.mp3')) continue;
        $movie = basename($movie);
        shell_exec($ffmpeg . ' -i /home/fluohead/public_html/mobile-oqra/uploads/'.$movie.' -acodec libmp3lame -ac 2 -ab 192k /home/fluohead/public_html/mobile-oqra/done/' . $movie . '.mp3 2>&1');
        sleep(2);
    }
}
