<?php
namespace App\Enums;

enum AlertMessage: string {

    case Proceeding                 = "We are proceeding. Please wait few seconds.";
    case NOTFOUND                   = "Data not found!";
    case SAVE                       = "Your data has been securely saved.";
    case UPDATE                     = "Your data has been updated successfully.";
    case REMOVE                     = "Your data has been removed successfully.";
    case CHECKSPORTORDER            = "Unable to delete this sports because it contains mapped orders.";
    case CHECKPRODUCTORDER          = "Unable to delete this product because it contains mapped orders.";
    case CHECKREMOVECHILDCATEGORY   = "Unable to delete this category because it contains child categories. Please remove or reassign the child categories before attempting to delete this category.";
    case CHECKREMOVEPRODUCTCATEGORY = "Unable to delete this category because it contains mapped products. Please reassign or remove the products from this category before attempting to delete it.";
    case CHECKREMOVEPRODUCTCLUB     = "Unable to delete this category because it contains mapped products. Please reassign or remove the products from this club before attempting to delete it.";
    case VARIANTNOLONGER            = "You`ve added a sub-category to this category, so variants can no longer be added here.";
    case VARIANTCATEGORY            = "If you add a variant, then you won`t be able to add a child category/sub category under this category.";
    case CATEGORYNOLONGER           = "You`ve already added variants to this category, so adding child categories is no longer possible.";
    case CATEGORYVARIANT            = "If you add a child category/sub category, then you won`t be able to add variants under this category.";

}
