<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\Status;
use App\Entity\Variation;
use App\Entity\VariationValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    /**
     * @var ObjectManager
     */
    protected $manager;
    
    protected $products = [
        [
            "name"          => "MANCHESTER UNITED HOME JERSEY",
            "description"   => "Manchester United's treble-winning team earned 
                the club a place in the record books and hearts of football fans worldwide. 
                This home jersey honours 20 years since that fateful night in Barcelona. 
                Made for fans, this version has a looser cut than the one players wear on match days. 
                It's built from sweat-wicking fabric, with commemorative details and a 
                special crest honouring their incredible 1998/99 season.",
            "images" => [
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw07698183/zoom/FK9990_21_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw18981d23/zoom/FK9990_25_model.jpg?sh=840&strip=false&sw=840"
            ]
        ],
        [
            "name"          => "BB PRINT TEE",
            "description"   => "Clean and classic, this crewneck t-shirt showcases adidas heritage. 
                It's built for comfort from soft, heavyweight cotton. The large adidas Trefoil logo in 
                front stands out against a geometric backdrop.",
            "images" => [
                "zoom/FK9990_25_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwe7b2885f/zoom/FK9991_25_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwdde080b8/zoom/CW0709_21_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwdde080b8/zoom/CW0709_21_model.jpg?sh=840&strip=false&sw=840",
            ]
        ],

        [
            "name"          => "ADIDAS ATHLETICS PACK TEE",
            "description"   => "You can step off the pitch, but your heart stays on it. This t-shirt is designed in honour of the sporty life. It displays a mash-up of bold adidas graphics on soft cotton jersey fabric. The loose fit gives you room to move.",
            "images" => [
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw1acdb134/zoom/CW1202_21_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw6f4ff4cd/zoom/DX6975_21_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwd0237161/zoom/DX6927_21_model.jpg?sh=840&strip=false&sw=840"
            ]
        ],

        [
            "name"          => "HARDEN SWAGGER ART GRAPHIC TEE",
            "description"   => "James Harden cooks. This basketball t-shirt features a \"Harden's cookin' em up\" graphic on the chest to celebrate the signature style of one of the best scorers in the league. The tee is made of a blend of cotton and polyester for a soft feel. It's designed to wick away moisture so you stay dry when the heat ratchets up on your pickup run.",
            "images" => [
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw1acdb134/zoom/CW1202_21_model.jpg?sh=840&strip=false&sw=840",               
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwd0237161/zoom/DX6927_21_model.jpg?sh=840&strip=false&sw=840"
            ]
        ],

        [
            "name"          => "HARDEN SWAGGER ART GRAPHIC TEE",
            "description"   => "James Harden cooks. This basketball t-shirt features a \"Harden's cookin' em up\" graphic on the chest to celebrate the signature style of one of the best scorers in the league. The tee is made of a blend of cotton and polyester for a soft feel. It's designed to wick away moisture so you stay dry when the heat ratchets up on your pickup run.",
            "images" => [
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw6f4ff4cd/zoom/DX6975_21_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwd0237161/zoom/DX6927_21_model.jpg?sh=840&strip=false&sw=840"
            ]
        ],

        [
            "name"          => "HARDEN SWAGGER VERB TEE",
            "description"   => "This basketball t-shirt shows off your love for James Harden, one of the best scorers in league history. Made of a blend of soft cotton and polyester single jersey, the tee features sweat-wicking fabric to sweep moisture away from your skin. Big and bold Harden graphics stand out on the chest and back.",
            "images" => [
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw6f4ff4cd/zoom/DX6975_21_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwd0237161/zoom/DX6927_21_model.jpg?sh=840&strip=false&sw=840"
            ]
        ],

        [
            "name"          => "NOT SAME VERB TEE",
            "description"   => "This basketball t-shirt is built for playmakers and creators on and off the hardwood. It's made of moisture-wicking fabric with a bit of stretch for ease of movement and dry comfort. A bold graphic on the back puts your mentality front and centre.",
            "images" => [
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dw18981d23/zoom/FK9990_25_model.jpg?sh=840&strip=false&sw=840",
                "https://www.adidas.com.ph/dw/image/v2/bcbs_prd/on/demandware.static/-/Sites-adidas-products/default/dwe7b2885f/zoom/FK9991_25_model.jpg?sh=840&strip=false&sw=840",
            ]
        ]
    ];

    protected $variations = [
            "Size" => [
                "name" => "Size",
                "variationValues" => ["S", "M", "L", "XL"]
            ],
            "Color" => [
                "name" => "Color",
                "variationValues" => ["Red", "Green", "White", "Blue"]
            ]
        ];
    
    protected $statuses = [
        [
            "name" => "Active",
            "description" => "Active Status"
        ],
        [
            "name" => "Deleted",
            "description" => "Deleted Status"
        ]
    ];

    /**
     * @var Generator
     */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->createVariations();
        $this->createStatuses();

        foreach($this->products as $product) {
            $this->createProduct($product);
        }
    }

    private function createStatuses() {
        foreach ($this->statuses as $statusArr) {
            $status = new Status();
            $status
                ->setName($statusArr["name"])
                ->setDescription($statusArr["description"]);
            $this->manager->persist($status);
        }

        $this->manager->flush();
    }

    private function createVariations() {

        foreach ($this->variations as $variation) {
            $this->createVariation($variation["name"]);
            $this->createVariationValues($variation["variationValues"]);

            // Assign the values to variation randomly
            $this->setRamdomVariationValues();
        }
    }

    /**
     * @param Product $product
     */
    private function assignProductVariations(Product $product) {

        $variations = $this->manager->getRepository('App\Entity\Variation')->findAll();

        foreach ($variations as $variation) {
            $product->getVariations()->add($variation);
            $this->manager->persist($variation);
            $this->manager->persist($product);
            $this->manager->flush();
        }
    }

    private function createProduct($productArray) {
        $product = new Product();
        $price = $this->faker->randomFloat(2, 10, 30);
        $rating = rand(0, 5);
        $status = $this->manager->getRepository(Status::class)
            ->findOneBy(["name" => "Active"]);
            
        $product->setName($productArray["name"])
            ->setDescription($productArray["description"])
            ->setStatus($status)
            ->setPrice($price)
            ->setRating($rating);

        $this->manager->persist($status);
        $this->manager->persist($product);
        $this->manager->flush();

        // Assign variation
        $this->assignProductVariations($product);
        $this->addProductImages($product, $productArray["images"]);
    }

    public function addProductImages(Product $product, $imagesUrls) {
        foreach($imagesUrls as $imageUrl) {
            $productImage = new ProductImage();
            $productImage->setProduct($product);
            $productImage->setUrl($imageUrl);
            $this->manager->persist($productImage);
            $this->manager->persist($product);
        }

        $this->manager->flush();
    }

    private function createVariation($variationName) {
        $variation = new Variation();
        $variation->setName($variationName);
        $this->manager->persist($variation);
        $this->manager->flush();
    }

    private function createVariationValues($variationValues) {
        foreach ($variationValues as $val) {
            $variationValue = new VariationValue();
            $variationValue->setValue($val);
            $this->manager->persist($variationValue);
            $this->manager->flush();
        }
    }

    private function setRamdomVariationValues() {
        $variations = $this->manager->getRepository('App\Entity\Variation')->findAll();

        /**
         * @var Variation $variation
         */
        foreach ($variations as $variation) {

            $variationValues = $this->variations[$variation->getName()]['variationValues'];
            $chosenVariationValue = $this->faker->randomElement($variationValues);

            $variationValueObject = $this->manager->getRepository('App\Entity\VariationValue')->findOneBy([
                "value" => $chosenVariationValue
            ]);

            $variation->setVariationValue($variationValueObject);
            $this->manager->persist($variationValueObject);
            $this->manager->persist($variation);
            $this->manager->flush();
        }
    }
}
