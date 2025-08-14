<?php

namespace App\Enums;

enum AlertMessage: string
{

    case Proceeding = "We are proceeding. Please wait few seconds.";
    case NOTFOUND = "Data not found!";
    case SAVE = "Your data has been securely saved.";
    case UPDATE = "Your data has been updated successfully.";
    case REMOVE = "Your data has been removed successfully.";
    const CHECKSPORTORDER = "Unable to delete this sports because it contains mapped orders.";
    const CHECKPRODUCTORDER = "Unable to delete this product because it contains mapped orders.";
    case CHECKREMOVECHILDCATEGORY = "Unable to delete this category because it contains child categories. Please remove or reassign the child categories before attempting to delete this category.";
    case CHECKREMOVEPRODUCTCATEGORY = "Unable to delete this category because it contains mapped products. Please reassign or remove the products from this category before attempting to delete it.";
    case CHECKREMOVEPRODUCTCLUB = "Unable to delete this category because it contains mapped products. Please reassign or remove the products from this club before attempting to delete it.";
    case ADDCOMPANYINFO="Please add your company information first to unlock additional benefits and enjoy a more personalized experience!";
}
