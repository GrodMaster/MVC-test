<?
class Home
{
    use Controller;

    public function index()
    {
        // $user = new User;

        // $result = $user->findAll();

        $this->view('home');
    }
}
