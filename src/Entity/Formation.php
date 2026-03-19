<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
#[Vich\Uploadable]
class Formation
{

    /**
     * Début de chemin vers les images
     */
    private const CHEMINIMAGE = "https://i.ytimg.com/vi/";
        
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\NotNull(message: "La date est obligatoire")]
    #[Assert\LessThanOrEqual("today", message: "La date ne peut pas être dans le futur")]
    private ?\DateTimeInterface $publishedAt = null;

    #[ORM\Column(length: 100, nullable: false)]
    #[Assert\NotBlank(message: "le titre est obligatoire")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $videoId = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[Assert\NotNull(message: "La playlist est obligatoire")]
    private ?Playlist $playlist = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'formations')]
    private Collection $categories;
    
    #[Vich\UploadableField(mapping: 'formation_video', fileNameProperty: 'videoName', size: 'videoSize')]
    private ?File $videoFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $videoName = null;

    #[ORM\Column(nullable: true)]
    private ?int $videoSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getPublishedAtString(): string {
        if($this->publishedAt == null){
            return "";
        }
        return $this->publishedAt->format('d/m/Y');     
    }      
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): static
    {
        $this->videoId = $videoId;

        return $this;
    }

    public function getMiniature(): ?string
    {
        return self::CHEMINIMAGE.$this->videoId."/default.jpg";
    }

    public function getPicture(): ?string
    {
        return self::CHEMINIMAGE.$this->videoId."/hqdefault.jpg";
    }
    
    public function getPlaylist(): ?playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
    
    public function getVideoFile(): ?File {
        return $this->videoFile;
    }

    public function getVideoName(): ?string {
        return $this->videoName;
    }

    public function getVideoSize(): ?int {
        return $this->videoSize;
    }

    public function setVideoFile(?File $videoFile): void {
        $this->videoFile = $videoFile;
        if(null !== $videoFile){
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function setVideoName(?string $videoName): void {
        $this->videoName = $videoName;
    }

    public function setVideoSize(?int $videoSize): void {
        $this->videoSize = $videoSize;
    }
    

}
