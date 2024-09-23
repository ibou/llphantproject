<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class VideoService
{
  public function __construct(
    private readonly EntityManagerInterface $em,
    private readonly VideoRepository $videoRepository
  ) {}

  /**
   * @param string $title The title of the video
   * @param string $description The description of the video
   * @param string[] $tags An array of tags for the video
   * @return Video
   * 
   */
  public function createVideo(string $title = '', string $description = '', array $tags = []): Video
  {
    $video = new Video();
    $video->setTitle($title);
    $video->setDescription($description);
    $video->setTags($tags);
    $this->save($video);
    return $video;
  }

  public function save(Video $video): void
  {
    $this->em->persist($video);
    $this->em->flush();
  }

  public function findAllVideos(): array
  {
    return $this->videoRepository->findBy([], ['id' => 'DESC']);
  }
}
