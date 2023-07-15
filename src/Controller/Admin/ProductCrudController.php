<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use phpDocumentor\Reflection\Types\Integer;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public const PRODUCTS_BASE_PATH = 'uploads/images/products';
    public const PRODUCTS_UPLOAD_DIR = 'public/uploads/images/products';




    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description'),
            MoneyField::new('price', 'Prix')
                ->setCurrency('EUR')
                ->setFormTypeOption('attr', ['inputmode' => 'decimal']),
            IntegerField::new('quantity', 'Stock'),
            ImageField::new('image')
                ->setSortable(false)
                ->setBasePath(self::PRODUCTS_BASE_PATH) // Chemin de base pour les images téléchargées
                ->setUploadDir(self::PRODUCTS_UPLOAD_DIR) // Répertoire de téléchargement des images
                ->setUploadedFileNamePattern('[randomhash].[extension]'), // Modèle de nommage des fichiers téléchargés,

            AssociationField::new('category', 'Categorie')

        ];
    }
}
