
<?php
use App\Entity\User;

class Clasecita
{
    private $fecha;
    private $descripcion;
    private $nombre;
    private $user;
    private $id;

    public function __construct(string $user, DateTime $fecha, string $nombre, int $id)
    {
        $this->user = $user;
        $this->nombre= $nombre;
        $this->fecha = $fecha->format('d-m-Y');
        $this->id = $id;
    }

    public function getId() : int{
        return $this->id;
    }

    public function getUser() : string{
        return $this->user;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

}
