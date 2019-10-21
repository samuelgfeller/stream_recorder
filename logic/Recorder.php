<?php


class Recorder
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Create the download directories if they don't exist
     */
    public function createDownloadDirectories()
    {
        if (!file_exists($this->config['video_directory']) && !mkdir($concurrentDirectory = $this->config['video_directory'],
                0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!file_exists($this->config['thumbnail_directory']) && !mkdir($concurrentDirectory = $this->config['thumbnail_directory'],
                0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        if (!file_exists($this->config['thumbnail_directory'] . 'thumbnail_not_found.jpg')) {
            $img = $this->config['thumbnail_directory'] . 'thumbnail_not_found.jpg';
            file_put_contents($img, file_get_contents($this->config['thumbnail_not_found_url']));
        }
    }

    /**
     * Retrieve the video name from a given Youtube URL
     *
     * @param $url
     * @return mixed
     */
    public function getVideoName($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://noembed.com/embed?url=' . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'cache-control: no-cache'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if (!empty($err)) {
            echo $err;
        }
        curl_close($curl);
        $responseArr = json_decode($response, true);
        return $responseArr['title'] ?? 'Live stream (title not found)';
    }

    /**
     * Generate filename which contains the config download path, the file name
     * which is the the video name with removed special chars and spaces replaced with hyphens ("-")
     * and in given extension in config.
     * If the file already exists a counted up number is added to the filename (video1.mp4)
     *
     * @param $videoName
     * @return string
     */

    public function createFileName($videoName): string
    {
        $fileName = str_replace(' ', '-', $videoName); // Replaces all spaces with hyphens.
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName); // Removes special chars.
        $fileName = preg_replace('/-+/', '-', $fileName); // Replaces multiple hyphens with single one.
        $fullFileName = $this->config['video_directory'] . $fileName . $this->config['video_extension']; // Set final file name with path and extension

        // https://stackoverflow.com/a/16136562/9013718
        $i = 1;
        while (file_exists($fullFileName)) {
            $fullFileName = $this->config['video_directory'] . $fileName . $i . $this->config['video_extension'];
            $i++;
        }
        return $fullFileName;
    }

    /**
     * Get the HTTP Live Streaming link with the youtube url
     *
     * @param $youtubeUrl
     * @return mixed
     */
    public function getHLSLink($youtubeUrl)
    {
        // Command to retrieve hls playlist
        $youtubeDlCommand = ('youtube-dl ' . '-g ' . escapeshellarg($youtubeUrl));

// Execute the command
        $output = shell_exec($youtubeDlCommand);
// Expected is the hls link so I assume that it's correct if the output starts with 'http'
        if (strpos($output, 'http') === 0) {
            // Remove newlines
            return str_replace(array("\r", "\n"), '', $output);
        }

        echo 'Error command output doesn\'t start with expected http. <br><br>';
        echo 'Youtube-dl command: <br><pre><b>' . $youtubeDlCommand . '</b></pre><br>';
        echo 'Output: <br><pre><b>' . $output . '</b><pre><br>';
        var_dump($output);
        die();
    }

    /**
     * Actually record the live stream with ffmpeg
     * The console output is sent to the client while recording
     *
     * @param $hlsLink
     * @param $fileName
     */
    public function recordStream($hlsLink, $fileName)
    {
        // indexed array where the key represents the descriptor number and the value represents how PHP will pass that descriptor to the child process
        $descriptorspec = array(
            0 => ['pipe', 'r'],  // stdin
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w'],  // stderr
        );

        // ffmpeg command
        $ffmpeg = 'ffmpeg -re -i "' . $hlsLink . '" -t ' . $this->config['max_record_time'] . ' -c copy ' . escapeshellcmd($fileName);

        // Set execution time limit up to the given max record time + 60 seconds for overhead
        set_time_limit($this->config['max_record_time'] + 60);

        // Execute the command and get the process
        $process = proc_open($ffmpeg, $descriptorspec, $pipes);
        if (is_resource($process)) {
            while ($s = fgets($pipes[2])) {
                // Remove newlines because somehow it doesn't get populated if there is a newline
                $s = str_replace(["\r", "\n"], '', $s);
                echo '<script>document.getElementById("consoleOutput").value += "' . $s . '\n";
    document.getElementById("consoleOutput").scrollTop = document.getElementById("consoleOutput").scrollHeight;</script>';
                flush();
                ob_flush();
            }
        }
        $ffmpegOut1 = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $ffmpegOut2 = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $ret = proc_close($process);
    }

    /**
     * Makes a snapshot at 0.1 seconds in the video and
     * saves it as jpg to use it as thumbnail
     *
     * @param $videoFullName string name with path
     */
    public function createThumbnail(string $videoFullName)
    {
        $videoNameParts = pathinfo($videoFullName);
        $thumbnail = $this->config['thumbnail_directory'] . $videoNameParts['filename'] . '.jpg';
        shell_exec("ffmpeg -i $videoFullName -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
    }
}
