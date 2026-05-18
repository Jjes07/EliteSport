<?php

namespace Tests\Unit;

use App\Models\Review;
use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase
{
    public function test_can_be_edited_only_by_owner(): void
    {
        $review = new Review();
        $review->setUserId(1);

        $this->assertTrue($review->canBeEditedBy(1));
        $this->assertFalse($review->canBeEditedBy(2));
    }
}