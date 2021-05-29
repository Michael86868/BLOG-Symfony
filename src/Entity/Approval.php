<?php

namespace App\Entity;

use App\Repository\ApprovalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ApprovalRepository::class)
 */
class Approval
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $isApproved;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="approvals")
     */
    private ?UserInterface $approvedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $approvedAt;

    public function __construct()
    {
        $this->isApproved = false;
        $this->approvedBy = null;
    }

    public function approve(UserInterface $approver): bool
    {
        try {
            $this->setIsApproved(true);
            $this->setApprovedBy($approver);
            $this->setApprovedAt(new \DateTimeImmutable());
        } catch (\Exception $exception) {
            throw $exception;
        }
        return true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(?bool $isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function getApprovedBy(): ?UserInterface
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?UserInterface $approvedBy): self
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    public function getApprovedAt(): ?\DateTimeInterface
    {
        return $this->approvedAt;
    }

    public function setApprovedAt(?\DateTimeInterface $approvedAt): self
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }
}
