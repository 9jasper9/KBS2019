 <?php
/**
 * Created by PhpStorm.
 * User: Jasper
 * Date: 2-11-2018
 * Time: 15:49
 */

class products
{

    public function fetch($id)
    {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitems WHERE StockItemId = :product";
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':product', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    // Algemene product zoek functie
    // deze functie maakt een lijst van producten.
    // we beginnen met het maken van stukjes SQL-query. die plakken we op het eind aan elkaar
    // op basis van pagina nummer, sorteren, groep en zoekfunctie word de SQL-query samengesteld in stapjes.
    public function fetchAllRequested(){
        
        // we willen de connectie gebruiken die in header.php word gedefenieerd.
        global $connection;
        
        // indien er een pagina nummer in de GET query staat, gebruik die om de query te LIMIT-en
        $pagenumber=0;
        if(isset($_GET["page"])){ $pagenumber=(int)htmlspecialchars($_GET["page"]); }
        $pageamount = 10; //standaardwaarde
        if(isset($_GET["amount"])){
            if($_GET["amount"]=="products-10"){
                $pageamount=10; }
            if($_GET["amount"]=="products-30"){
                $pageamount=30; }
            if($_GET["amount"]=="products-40"){
                $pageamount=40; }
            if($_GET["amount"]=="products-50"){
                $pageamount=50; }
        }
        
        $sql_limit="LIMIT ".($pagenumber*$pageamount).",".$pageamount;
        
        
        // indien er gesorteerd is, gebruik de geselecteerde sortering.
        // standaard sorteren op naam, oplopend
        $sql_sort="ORDER BY StockItemName ASC";
        // als er gesorteerd is,
        if(isset($_GET["sort"])){
            // sorteer dan op de aangegeven sorteermogelijkheid.
            if($_GET["sort"]=="titledesc"){ $sql_sort="ORDER BY StockItemName DESC"; }
            if($_GET["sort"]=="priceasc" ){ $sql_sort="ORDER BY RecommendedRetailPrice ASC"; }
            if($_GET["sort"]=="pricedesc"){ $sql_sort="ORDER BY RecommendedRetailPrice DESC"; }
        }
        
        // indien er een categorie is genoemd, en de categorie niet 0 (alle categorien) is,
        // vul dan een WHERE conditie in.
        // hou bij of de categorie is aangegeven, dat moeten we later weten
        $sql_category="";
        $hasCategory=FALSE;
        if(isset($_GET['category']) and (int)$_GET['category']!=0){
            $sql_category="StockGroupID = ".(int)htmlspecialchars($_GET['category']);
            $hasCategory=TRUE;
        }
        
        // indien er een zoekopdracht gedaan word, vul dan een zoek WHERE conditie in.
        $sql_search="";
        // hou bij of er gezocht was, dat moeten we later weten
        $hasSearch=FALSE;
        if(isset($_GET['search'])){
            // search is de zoekstring waar we op zoeken
            $search="%".htmlspecialchars($_GET['search'])."%";
            // maak het search gedeelte van de query
            $sql_search="StockItemName LIKE '".$search."'";
            $hasSearch=TRUE;
        }
        
        
        // als er zowel een categorie is als een zoekopdracht,
        // dan willen we AND gebruiken.
        if($hasCategory and $hasSearch){
                $sql_category="AND ".$sql_category;
        }
        
        // als er geen zoekopdracht of categorie is, dan gewoon alles ophalen. (WHERE TRUE)
        if(! ($hasCategory OR $hasSearch)){
            $sql_search = "TRUE";
        }
        
        // de basis querie. hier plakken we de delen achter.
        $sql_select="SELECT DISTINCT(stockitems.StockItemID), RecommendedRetailPrice, StockItemName, Photo FROM stockitems LEFT JOIN stockitemstockgroups ON stockitems.StockItemID = stockitemstockgroups.StockItemID";
        
        // plak alles aan elkaar.
        $query=$sql_select." WHERE ".$sql_search." ".$sql_category." ".$sql_sort." ".$sql_limit . "";
        //echo $query;
        
        
        // prepare de SQL statement
        $statement = $connection->prepare($query);
        
        // voer de query uit
        $statement->execute();
        
        // geef de lijst met resultaten terug.
        return $statement->fetchAll();
    }
    
    
    public function fetchCatForProduct($id)
    {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitemstockgroups WHERE StockItemID = :product";
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':product', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }


    public function fetchAlts($name)
    {
        try {
            $name = "%" . explode("(", $name)[0] . "%";
            global $connection;
            $sql = "SELECT * FROM stockitems WHERE StockItemName LIKE :product";
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':product', $name, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public function fetchAllForCatLimit($category_id,$offset,$count) {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitems LEFT JOIN stockitemstockgroups ON stockitems.StockItemID = stockitemstockgroups.StockItemID WHERE StockGroupID = :category LIMIT :offset,:count";
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':category', $category_id, PDO::PARAM_INT);
            $stmt->bindparam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindparam(':count', $count, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public function fetchAllForCat($category_id){
        return self::fetchAllForCatLimit($category_id,0,40);
    }
    

    public function fetchAllForCatTitle($category_id, $direction) {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitems LEFT JOIN stockitemstockgroups ON stockitems.StockItemID = stockitemstockgroups.StockItemID WHERE StockGroupID = :category ORDER BY StockItemName ".$direction;
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':category', $category_id, PDO::PARAM_INT);
            //$stmt->bindparam(':direction', $direction, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public function fetchAllForCatPrice($category_id, $price_order) {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitems LEFT JOIN stockitemstockgroups ON stockitems.StockItemID = stockitemstockgroups.StockItemID WHERE StockGroupID = :category ORDER BY RecommendedRetailPrice ".$price_order;
            $stmt = $connection->prepare($sql);
            $stmt->bindparam(':category', $category_id, PDO::PARAM_INT);
            //$stmt->bindparam(':price', $price_order, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public function fetchAll()
    {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitems WHERE StockItemID > 176";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    
    
    public function fetchAllCatNames() {
        try {
            global $connection;
            $sql = "SELECT * FROM stockgroups";
            $stmt = $connection->prepare($sql);;
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public function fetchCat($id) {
        try {
            global $connection;
            $sql = "SELECT * FROM stockgroups WHERE StockGroupID = :id";
            $stmt = $connection->prepare($sql);;
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        }catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function translateCustomFields($key)
    {
        switch ($key) {
            default:
                return ucfirst($key);
            case "CountryOfManufacture":
                return "Land van oorsprong";
            case "MinimumAge":
                return "Minimale leeftijd";
        }
    }

    public function fetchStockitemholdings($product) {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitemholdings WHERE StockItemID = :product";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':product', $product, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch(PDOException $e) {
            echo 'PDO ERROR: ' . $e->getMessage();
        }
    }

    public function fetchMedia($StockItemID) {
        try {
            global $connection;
            $sql = "SELECT * FROM stockitems_media WHERE StockItemID = :product";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':product', $StockItemID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo 'PDO ERROR: ' . $e->getMessage();
        }
    }


}
