<?php 

class ArticleController 
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome() : void
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->getAllArticles();

        $view = new View("Accueil");
        $view->render("home", ['articles' => $articles]);
    }

    /**
     * Affiche le détail d'un article.
     * @return void
     */
    public function showArticle() : void
    {
        
        // Récupération de l'id de l'article demandé.
        $id = Utils::request("id", -1);

        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($id);
        
        if (!$article) {
            throw new Exception("L'article demandé n'existe pas.");
        }

        // INCREMENTER VIEWS COUNT
        $articleManager->incrementViews($id);

        $commentManager = new CommentManager();
        $comments = $commentManager->getAllCommentsByArticleId($id);

        $view = new View($article->getTitle());
        $view->render("detailArticle", ['article' => $article, 'comments' => $comments]);
    }

    /**
     * Affiche le formulaire d'ajout d'un article.
     * @return void
     */
    public function addArticle() : void
    {
        $view = new View("Ajouter un article");
        $view->render("addArticle");
    }

    /**
     * Affiche la page "à propos".
     * @return void
     */
    public function showApropos() {
        $view = new View("A propos");
        $view->render("apropos");
    }

    // FONCTION DE TRI USORT
    public function showMonitoring() : void
    {
        // Get sort & order depuis l'URL
        $sort = $_GET['sort'] ?? 'title';
        $order = $_GET['order'] ?? 'ASC';

        $articleManager = new ArticleManager();
        $articles = $articleManager->getAllArticles();

        // Tri des article uniquement en PHP
        $this->sortArticles($articles, $sort, $order);

        $view = new View("Monitoring");
        $view->render("monitoring", ['articles' => $articles, 'order' => $order, 'sort' => $sort]);
    }

    // Tri en fonction du critère $sort et et de l'ordre de tri $order
    private function sortArticles(&$articles, $sort, $order)
    {
        usort($articles, function($a, $b) use ($sort, $order) {
            // Extraction des valeurs à comparer au critère de tri
            $valueA = $this->getSortValue($a, $sort);
            $valueB = $this->getSortValue($b, $sort);

            // Si 2 éléments sont égaux alors ils gardent la même place
            if ($valueA == $valueB) {
                return 0;
            }

            // Gestion de l'orde du tri en fonction des valeurs 
            if ($order === 'ASC') {
                return $valueA < $valueB ? -1 : 1;
            } else {
                return $valueA > $valueB ? -1 : 1;
            }
        });
    }

    private function getSortValue($article, $sort)
    {
        switch ($sort) {
            case 'views':
                return $article->getViews();
            case 'comments':
                return $article->getCommentCount();
            case 'date_creation':
                return $article->getDateCreation()->getTimestamp();
            case 'title':
            default:
                return $article->getTitle();
        }
    }
}