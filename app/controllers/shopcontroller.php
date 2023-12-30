<?php
namespace MVC\controllers;
use MVC\core\controller;
use MVC\models\shop;
class shopcontroller extends controller {
    public function search($pro_name) {
        if (!isset($pro_name)) {
            helper::redirect('home/index');
        }
        // Validate and sanitize inputs
        $order_by = isset($_GET['orderBy']) ? $_GET['orderBy'] : '';
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

        // Sanitize the inputs before using in the SQL query
        $order_by = filter_var($order_by, FILTER_SANITIZE_STRING);
        $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);

        $data = new shop();

        // Check if there is a search term provided and if it's not empty
        if (!empty($searchTerm)) {
            // Paginate the search results
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 5; // Number of products per page

            // Retrieve paginated search results based on the search term and pagination parameters
            if ($order_by === 'high_to_low') {
                $result = $data->search_by_higher($searchTerm, $page, $perPage); // Query for ordering by price high to low
            } elseif ($order_by === 'low_to_high') {
                $result = $data->search_by_lower($searchTerm, $page, $perPage); // Query for ordering by price low to high
            } elseif ($order_by === 'latest') {
                $result = $data->search_latest($page, $perPage); // Query for selecting the latest records
            } else {
                // Default query if orderBy parameter is not recognized or not provided
                $result = $data->search($searchTerm, $page, $perPage);
            }

            // Calculate total results count for the provided search term
            $totalResults = $data->getTotalResultsCount($searchTerm); // Method in the shop model
            $totalPages = ceil($totalResults / $perPage);
            // Check if search results exist before rendering the view
            if ($result !== null && !empty($result)) {
                $this->view('shop/search', [
                    'title' => 'shop',
                    'result' => $result,
                    'totalPages' => $totalPages,
                    'currentPage' => $page
                ]);
            } else {
                // Handle case when no search results found
                // Example: Redirect to a default page or display an appropriate message
                $this->view('shop/search', ['title' => 'shop', 'not_found' => 'nothing was found']);
            }
        } else {
            // Handle invalid or empty search term
            $this->view('shop/search', ['title' => 'shop', 'empty_search' => 'search input is empty']);
            // Example: Redirect to a default page or display an appropriate message
        }
    }
}
?>
