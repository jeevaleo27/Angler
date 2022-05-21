1) SELECT * FROM `mCategories` LEFT JOIN `mSubCategories` ON mSubCategories.CategoriesUID = mCategories.CategoriesUID 
LEFT JOIN `mProducts` ON mProducts.SubCategoriesUID = mSubCategories.SubCategoriesUID WHERE mProducts.ProductStock > 0;

2)SELECT * FROM `mCategories` LEFT JOIN `mSubCategories` ON mSubCategories.CategoriesUID = mCategories.CategoriesUID 
LEFT JOIN `mProducts` ON mProducts.SubCategoriesUID = mSubCategories.SubCategoriesUID WHERE mCategories.CategoriesUID IN (1,3) AND mProducts.ProductStatus = 1;

3)SELECT * FROM mProducts where date_format( IssueDate, '%Y-%m' ) = '2011-04';

4)SELECT * FROM mProducts where ProductPrice BETWEEN 10 AND 60;

5)SELECT DATE_FORMAT(IssueDate,"%e %M ,%y") FROM `mProducts` where IssueDate=(SELECT MAX(IssueDate) FROM `mProducts`);

6)SELECT `ProductsUID`,DATE_FORMAT(IssueDate,"%e-%M-%Y at %l:%i%p") AS IssueDate ,`SubCategoriesUID`,`ProductName`,`ProductPrice`,`ProductStock`,`ProductStatus`FROM mProducts where date_format( IssueDate, '%Y-%m' ) = '2010-03';

7)SELECT CategoryName,sum(ProductPrice) FROM `mCategories` LEFT JOIN `mSubCategories` ON mSubCategories.CategoriesUID = mCategories.CategoriesUID 
LEFT JOIN `mProducts` ON mProducts.SubCategoriesUID = mSubCategories.SubCategoriesUID GROUP BY CategoryName;


8)SELECT  mProducts.ProductsUID,DATE_FORMAT(IssueDate,"%Y %D %M %l:%i:%s") AS IssueDate ,mProducts.SubCategoriesUID,mProducts.ProductName,mProducts.ProductPrice,mProducts.ProductStock,mProducts.ProductStatus FROM mProducts 
LEFT JOIN mSubCategories ON  mSubCategories.SubCategoriesUID=mProducts.SubCategoriesUID
LEFT JOIN mCategories ON  mCategories.CategoriesUID =mSubCategories.CategoriesUID WHERE mCategories.CategoriesUID IN (1,3);

9)DELETE mProducts from mProducts inner JOIN mSubCategories ON mSubCategories.SubCategoriesUID=mProducts.SubCategoriesUID inner JOIN mCategories ON mCategories.CategoriesUID =mSubCategories.CategoriesUID WHERE mCategories.CategoriesUID IN (1,2) AND mProducts.ProductStatus=1;

10)