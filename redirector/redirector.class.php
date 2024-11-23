<?php

class Redirector
{
    private string $video_id;
    private array $stream_map;

    public function __construct(string $link)
    {
        $this->video_id = $this->paresId($link);
        $this->stream_map = $this->paresStreamMap();
    }

    private function paresId(string $link): string
    {
        preg_match('/(?:https?:\/\/)?(?:[\w\-]+\.)*(?:drive|docs)\.google\.com\/(?:(?:folderview|open|uc)\?(?:[\w\-\%]+=[\w\-\%]*&)*id=|(?:folder|file|document|presentation)\/d\/|spreadsheet\/ccc\?(?:[\w\-\%]+=[\w\-\%]*&)*key=)([\w\-]{28,})/i', $link, $match);
        return $match[1] ?? "error";
    }

    private function paresStreamMap(): array
    {
        $video_info = file_get_contents('https://drive.google.com/get_video_info?docid=' . $this->video_id);
        parse_str($video_info, $data);
        $streames = explode(',', $data['fmt_stream_map']);
        foreach ($streames as $stream) {
            $stream    = explode('|', $stream);
            $quality[] = $stream[0];
            $label[]   = $stream[1];
        }
        return array_combine($quality, $label);
    }

    public function getId(): string
    {
        return $this->video_id;
    }

    public function getMap(): array
    {
        return $this->stream_map;
    }
}
