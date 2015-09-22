<?php

/**********************************************************************************************************************
 * phpLINQ (https://github.com/mkloubert/phpLINQ)                                                                     *
 *                                                                                                                    *
 * Copyright (c) 2015, Marcel Joachim Kloubert <marcel.kloubert@gmx.net>                                              *
 * All rights reserved.                                                                                               *
 *                                                                                                                    *
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the   *
 * following conditions are met:                                                                                      *
 *                                                                                                                    *
 * 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the          *
 *    following disclaimer.                                                                                           *
 *                                                                                                                    *
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the       *
 *    following disclaimer in the documentation and/or other materials provided with the distribution.                *
 *                                                                                                                    *
 * 3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote    *
 *    products derived from this software without specific prior written permission.                                  *
 *                                                                                                                    *
 *                                                                                                                    *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, *
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE  *
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, *
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,  *
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE   *
 * USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                                           *
 *                                                                                                                    *
 **********************************************************************************************************************/


function zipFunc($itemA, $itemB) {
    return sprintf('%s%s', $itemA, $itemB);
}


/**
 * @see \System\Collection\IEnumerable::zip().
 *
 * @author Marcel Joachim Kloubert <marcel.kloubert@gmx.net>
 */
class ZipTests extends TestCaseBase {
    /**
     * Creates zipper callables.
     *
     * @return array The list of zippers.
     */
    protected function createZippers() : array {
        return array(
            function($itemA, $itemB) {
                return sprintf('%s%s', $itemA, $itemB);
            },
            '$itemA, $itemB => sprintf("%s%s", $itemA, $itemB)',
            '($itemA, $itemB) => sprintf("%s%s", $itemA, $itemB)',
            '$itemA, $itemB => return sprintf("%s%s", $itemA, $itemB);',
            '($itemA, $itemB) => return sprintf("%s%s", $itemA, $itemB);',
            '$itemA, $itemB => {
return sprintf("%s%s", $itemA, $itemB);
}',
            '($itemA, $itemB) => {
return sprintf("%s%s", $itemA, $itemB);
}',
            '$itemA, $itemB => {return sprintf("%s%s", $itemA, $itemB); }',
            '($itemA, $itemB) => { return sprintf("%s%s", $itemA, $itemB);}',
            array($this, 'zipper1'),
            array(static::class, 'zipper2'),
            'zipFunc',
        );
    }

    public function testArray1() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3]);
            $b = ['A', 'B', 'C', 'D'];

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(3, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
        }
    }

    public function testArray2() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3]);
            $b = ['A', 'B'];

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(2, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
        }
    }

    public function testArray3() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3, 4]);
            $b = ['A', 'B', 'C', 'd'];

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(4, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
            $this->assertEquals('4d', $items[3]);
        }
    }

    public function testIterator1() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3, 4]);
            $b = new ArrayIterator(['A', 'B', 'C', 'd']);

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(4, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
            $this->assertEquals('4d', $items[3]);
        }
    }

    public function testIterator2() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3, 4]);
            $b = new ArrayIterator(['A', 'B']);

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(2, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
        }
    }

    public function testIterator3() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3, 4]);
            $b = new ArrayIterator(['A', 'B', 'C', 'd']);

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(4, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
            $this->assertEquals('4d', $items[3]);
        }
    }

    public function testGenerator1() {
        $createGenerator = function() {
            yield 'A';
            yield 'B';
            yield 'C';
            yield 'D';
        };

        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3]);
            $b = $createGenerator();

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(3, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
        }
    }

    public function testGenerator2() {
        $createGenerator = function() {
            yield 'A';
            yield 'B';
        };

        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3]);
            $b = $createGenerator();

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(2, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
        }
    }

    public function testGenerator3() {
        $createGenerator = function() {
            yield 'A';
            yield 'B';
            yield 'C';
            yield 'd';
        };

        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3, 4]);
            $b = $createGenerator();

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(4, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
            $this->assertEquals('4d', $items[3]);
        }
    }

    public function testSequence1() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3]);
            $b = static::sequenceFromArray(['A', 'B', 'C', 'D']);

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(3, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
        }
    }

    public function testSequence2() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3]);
            $b = static::sequenceFromArray(['A', 'B']);

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(2, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
        }
    }

    public function testSequence3() {
        foreach ($this->createZippers() as $selector) {
            $a = static::sequenceFromArray([1, 2, 3, 4]);
            $b = static::sequenceFromArray(['A', 'B', 'C', 'd']);

            $items = [];
            foreach ($a->zip($b, $selector) as $x) {
                $items[] = $x;
            }

            $this->assertEquals(4, count($items));
            $this->assertEquals('1A', $items[0]);
            $this->assertEquals('2B', $items[1]);
            $this->assertEquals('3C', $items[2]);
            $this->assertEquals('4d', $items[3]);
        }
    }

    public function zipper1($itemA, $itemB) {
        return sprintf('%s%s', $itemA, $itemB);
    }

    public static function zipper2($itemA, $itemB) {
        return sprintf('%s%s', $itemA, $itemB);
    }
}
