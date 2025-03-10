<?php

namespace Front;

use App\Models\Category;
use Tests\UserTest;

class FrontCategoryTest extends UserTest
{
    public function test_index_should_return_all_categories_with_their_children()
    {
        $category = Category::factory()->create();
        Category::factory()->for($category, "parent")->create();
        $this->withoutExceptionHandling();
        $res = $this->getJson(route('v1.front.categories.index'));
        $this->assertCount(1, $res->json());
    }
}
