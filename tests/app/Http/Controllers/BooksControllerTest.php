<?php

namespace Tests\app\Http\Controllers;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function index_status_code_should_be_200()
    {
        $this
            ->get('/books')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function index_should_return_a_collection_of_records()
    {
        $books = Book::factory(2)->create();

        $response = $this->get('/books');

        foreach ($books as $book) {
            $response->assertJsonFragment(['title' => $book->title]);
        }
    }

    /** @test **/
    public function show_should_return_a_valid_book()
    {
        $book = Book::factory()->create();
        $response = $this
            ->get("/books/{$book->id}")
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'title' => $book->title,
                'description' => $book->description,
                'author' => $book->author
            ]);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('created_at', $data);
        $this->assertArrayHasKey('updated_at', $data);
    }

    /**
     * @test
     */
    public function show_should_fail_when_the_book_id_does_not_exist()
    {
        $this
            ->get('/books/99999')
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Book not found'
                ]
            ]);
    }

    /**
     * @test
     */
    public function store_should_save_new_book_in_the_database()
    {
        $response = $this->post('/books', [
            'title' => 'Solo Leveling',
            'description' => 'In a world where hunters — humans who possess magical abilities — must battle deadly monsters to protect the human race from certain annihilation, a notoriously weak hunter named Sung Jinwoo finds himself in a seemingly endless struggle for survival. One day, after narrowly surviving an overwhelmingly powerful double dungeon that nearly wipes out his entire party, a mysterious program called the System chooses him as its sole player and in turn, gives him the extremely rare ability to level up in strength, possibly beyond any known limits. Jinwoo then sets out on a journey as he fights against all kinds of enemies, both man and monster, to discover the secrets of the dungeons and the true source of his powers.',
            'author' => 'Chugong'
        ]);

        $response->assertJson([
            'created' => true
        ]);
        $this->assertDatabaseHas('books', ['title' => 'Solo Leveling']);
    }

    /**
     * @test
     */
    public function store_should_respond_with_a_201_and_location_header_when_successful()
    {
        $response = $this->post('/books', [
            'title' => 'Test Book',
            'description' => 'In a world where hunters — humans who possess magical abilities — must battle deadly monsters to protect the human race from certain annihilation, a notoriously weak hunter named Sung Jinwoo finds himself in a seemingly endless struggle for survival.',
            'author' => 'Chugong'
        ]);


        $response
            ->assertStatus(201)
            ->assertHeader('Location');
    }

    /**
     * @test
     */
    public function update_should_only_change_fillable_fields()
    {
        $book = Book::factory()->create([
            'title' => 'A song about ice and fire',
            'description' => 'A novel about essos and westeros where dynastic war and white walkers.',
            'author' => 'GRRM'
        ]);

        $this->assertDatabaseMissing('books', [
            'title' => 'A song of ice and fire'
        ]);

        $response = $this->put("/books/{$book->id}", [
            'id' => 5,
            'title' => 'A song of ice and fire',
            'description' => 'A Song of Ice and Fire takes place on the fictional continents Westeros and Essos. The point of view of each chapter in the story is a limited perspective of a range of characters growing from nine in the first novel, to 31 characters by the fifth novel. Three main stories interweave: a dynastic war among several families for control of Westeros, the rising threat of the supernatural Others in northernmost Westeros, and the ambition of the deposed king\'s exiled daughter to assume the Iron Throne.',
            'author' => 'George R. R. Martin'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'title' => 'A song of ice and fire',
                'description' => 'A Song of Ice and Fire takes place on the fictional continents Westeros and Essos. The point of view of each chapter in the story is a limited perspective of a range of characters growing from nine in the first novel, to 31 characters by the fifth novel. Three main stories interweave: a dynastic war among several families for control of Westeros, the rising threat of the supernatural Others in northernmost Westeros, and the ambition of the deposed king\'s exiled daughter to assume the Iron Throne.',
                'author' => 'George R. R. Martin'
            ]);
        $this->assertDatabaseHas('books', [
            'title' => 'A song of ice and fire'
        ]);
    }

    /**
     * @test
     */
    public function update_should_fail_with_an_invalid_id()
    {
        $this
            ->put('/books/999999')
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Book not found'
                ]
            ]);
    }

    /**
     * @test
     */
    public function update_should_not_match_an_invalid_route()
    {
        $this
            ->put('/books/this-is-invalid')
            ->assertStatus(404);

    }

    /** @test **/
    public function destroy_should_remove_a_valid_book()
    {
        $book = Book::factory()->create();

        $this->delete("/books/{$book->id}")
            ->assertStatus(204)
            ->isEmpty();

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /** @test **/
    public function destroy_should_return_a_404_with_an_invalid_id()
    {
        $this->delete('/books/9999999')
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Book not found'
                ]
            ]);
    }

    /** @test **/
    public function destroy_should_not_match_an_invalid_route()
    {
        $this->delete('/books/invalid-route')
            ->assertStatus(404);
    }
}
