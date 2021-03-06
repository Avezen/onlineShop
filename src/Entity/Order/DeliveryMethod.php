<?php

namespace App\Entity\Order;

use App\Entity\Order\PackageMethod;
use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Traversable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryMethodRepository")
 */
class DeliveryMethod implements Collection
{

    public function __construct()
    {
        $this->PackageMethods = new ArrayCollection();
    }


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;




    /**
     * @ORM\Column(type="string", length=120)
     */
    private $Name;



    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ArrivalDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order\PackageMethod", mappedBy="DeliveryMethod", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $PackageMethods;




    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }


    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->ArrivalDate;
    }

    public function setArrivalDate(?\DateTimeInterface $ArrivalDate): self
    {
        $this->ArrivalDate = $ArrivalDate;

        return $this;
    }



    /**
     * @return \Doctrine\Common\Collections\Collection|PackageMethod[]
     */
    public function getPackageMethods(): Collection
    {
        return $this->PackageMethods;
    }

    public function addPackageMethod(PackageMethod $packageMethod): self
    {
        if (!$this->PackageMethods->contains($packageMethod)) {
            $this->PackageMethods[] = $packageMethod;
            $packageMethod->setDeliveryMethod($this);
        }

        return $this;
    }

    public function removePackageMethod(PackageMethod $packageMethod): self
    {
        if ($this->PackageMethods->contains($packageMethod)) {
            $this->PackageMethods->removeElement($packageMethod);
            // set the owning side to null (unless already changed)
            if ($packageMethod->getDeliveryMethod() === $this) {
                $packageMethod->setDeliveryMethod(null);
            }
        }

        return $this;
    }

    /**
     * Adds an element at the end of the collection.
     *
     * @param mixed $element The element to add.
     *
     * @return bool Always TRUE.
     */
    public function add($element)
    {
        // TODO: Implement add() method.
    }

    /**
     * Clears the collection, removing all elements.
     *
     * @return void
     */
    public function clear()
    {
        // TODO: Implement clear() method.
    }

    /**
     * Checks whether an element is contained in the collection.
     * This is an O(n) operation, where n is the size of the collection.
     *
     * @param mixed $element The element to search for.
     *
     * @return bool TRUE if the collection contains the element, FALSE otherwise.
     */
    public function contains($element)
    {
        // TODO: Implement contains() method.
    }

    /**
     * Checks whether the collection is empty (contains no elements).
     *
     * @return bool TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    /**
     * Removes the element at the specified index from the collection.
     *
     * @param string|int $key The kex/index of the element to remove.
     *
     * @return mixed The removed element or NULL, if the collection did not contain the element.
     */
    public function remove($key)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Removes the specified element from the collection, if it is found.
     *
     * @param mixed $element The element to remove.
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeElement($element)
    {
        // TODO: Implement removeElement() method.
    }

    /**
     * Checks whether the collection contains an element with the specified key/index.
     *
     * @param string|int $key The key/index to check for.
     *
     * @return bool TRUE if the collection contains an element with the specified key/index,
     *              FALSE otherwise.
     */
    public function containsKey($key)
    {
        // TODO: Implement containsKey() method.
    }

    /**
     * Gets the element at the specified key/index.
     *
     * @param string|int $key The key/index of the element to retrieve.
     *
     * @return mixed
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * Gets all keys/indices of the collection.
     *
     * @return array The keys/indices of the collection, in the order of the corresponding
     *               elements in the collection.
     */
    public function getKeys()
    {
        // TODO: Implement getKeys() method.
    }

    /**
     * Gets all values of the collection.
     *
     * @return array The values of all elements in the collection, in the order they
     *               appear in the collection.
     */
    public function getValues()
    {
        // TODO: Implement getValues() method.
    }

    /**
     * Sets an element in the collection at the specified key/index.
     *
     * @param string|int $key The key/index of the element to set.
     * @param mixed $value The element to set.
     *
     * @return void
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * Gets a native PHP array representation of the collection.
     *
     * @return array
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    /**
     * Sets the internal iterator to the first element in the collection and returns this element.
     *
     * @return mixed
     */
    public function first()
    {
        // TODO: Implement first() method.
    }

    /**
     * Sets the internal iterator to the last element in the collection and returns this element.
     *
     * @return mixed
     */
    public function last()
    {
        // TODO: Implement last() method.
    }

    /**
     * Gets the key/index of the element at the current iterator position.
     *
     * @return int|string
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * Gets the element of the collection at the current iterator position.
     *
     * @return mixed
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * Moves the internal iterator position to the next element and returns this element.
     *
     * @return mixed
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * Tests for the existence of an element that satisfies the given predicate.
     *
     * @param Closure $p The predicate.
     *
     * @return bool TRUE if the predicate is TRUE for at least one element, FALSE otherwise.
     */
    public function exists(Closure $p)
    {
        // TODO: Implement exists() method.
    }

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     *
     * @return Collection A collection with the results of the filter operation.
     */
    public function filter(Closure $p)
    {
        // TODO: Implement filter() method.
    }

    /**
     * Tests whether the given predicate p holds for all elements of this collection.
     *
     * @param Closure $p The predicate.
     *
     * @return bool TRUE, if the predicate yields TRUE for all elements, FALSE otherwise.
     */
    public function forAll(Closure $p)
    {
        // TODO: Implement forAll() method.
    }

    /**
     * Applies the given function to each element in the collection and returns
     * a new collection with the elements returned by the function.
     *
     * @param Closure $func
     *
     * @return Collection
     */
    public function map(Closure $func)
    {
        // TODO: Implement map() method.
    }

    /**
     * Partitions this collection in two collections according to a predicate.
     * Keys are preserved in the resulting collections.
     *
     * @param Closure $p The predicate on which to partition.
     *
     * @return Collection[] An array with two elements. The first element contains the collection
     *                      of elements where the predicate returned TRUE, the second element
     *                      contains the collection of elements where the predicate returned FALSE.
     */
    public function partition(Closure $p)
    {
        // TODO: Implement partition() method.
    }

    /**
     * Gets the index/key of a given element. The comparison of two elements is strict,
     * that means not only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param mixed $element The element to search for.
     *
     * @return int|string|bool The key/index of the element or FALSE if the element was not found.
     */
    public function indexOf($element)
    {
        // TODO: Implement indexOf() method.
    }

    /**
     * Extracts a slice of $length elements starting at position $offset from the Collection.
     *
     * If $length is null it returns all elements from $offset to the end of the Collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the elements contained in the collection slice is called on.
     *
     * @param int $offset The offset to start from.
     * @param int|null $length The maximum number of elements to return, or null for no limit.
     *
     * @return array
     */
    public function slice($offset, $length = null)
    {
        // TODO: Implement slice() method.
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        // TODO: Implement count() method.
    }
}
