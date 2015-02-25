<?php
// HEADER

namespace Hostnet\Component\AccessorGenerator\Generator\fixtures\Generated;

use Doctrine\ORM\Mapping as ORM;
use Hostnet\Component\AccessorGenerator\Annotation as AG;
use Hostnet\Component\AccessorGenerator\Collection\ImmutableCollection;
use Hostnet\Component\AccessorGenerator\Generator\fixtures\Category;

trait CategoryMethodsTrait
{
    /**
     * Get children
     *
     * @return \Hostnet\Component\AccessorGenerator\Generator\fixtures\Category[]
     * @return \Hostnet\Component\AccessorGenerator\Collection\ConstCollectionInterface
     * @throws \InvalidArgumentException
     */
    public function getChildren()
    {
        if (func_num_args() > 0) {
            throw new \BadMethodCallException(
                sprintf(
                    'getChildren() has no arguments but %d given.',
                    func_num_args()
                )
            );
        }

        if ($this->children === null) {
            $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        }

        return new ImmutableCollection($this->children);
    }

    /**
     * Add child
     *
     * @param Category $child
     * @return Category
     * @throws \BadMethodCallException if the number of arguments is not correct
     */
    public function addChild(Category $child)
    {
        if (func_num_args() != 1) {
            throw new \BadMethodCallException(
                sprintf(
                    'addChildren() has one argument but %d given.',
                    func_num_args()
                )
            );
        }

        if ($this->children === null) {
            $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        } elseif ($this->children->contains($child)) {
            return $this;
        }

        $this->children->add($child);
        $property = new \ReflectionProperty($child, 'parent');
        $property->setAccessible(true);
        $value = $property->getValue($child);
        if ($value) {
            throw new \LogicException('Child can not be added to more than one Category.');
        }
        $property->setValue($child, $this);
        $property->setAccessible(false);
        return $this;
    }

    /**
     * Remove child
     *
     * @param Category $child
     * @return Category
     * @throws \BadMethodCallException if the number of arguments is not correct
     */
    public function removeChild(Category $child)
    {
        if (func_num_args() != 1) {
            throw new \BadMethodCallException(
                sprintf(
                    'removeChildren() has one argument but %d given.',
                    func_num_args()
                )
            );
        }

        if (! $this->children instanceof \Doctrine\Common\Collections\Collection
            || ! $this->children->contains($child)
        ) {
            return $this;
        }

        $this->children->removeElement($child);

        $property = new \ReflectionProperty($child, 'parent');
        $property->setAccessible(true);
        $property->setValue($child, null);
        $property->setAccessible(false);
        return $this;
    }
}
