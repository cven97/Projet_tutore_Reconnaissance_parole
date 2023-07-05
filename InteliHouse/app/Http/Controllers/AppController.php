<?php

namespace App\Http\Controllers;

use App\Models\Appareil;
use App\Models\Piece;
use App\Models\User;
use App\Models\UserAppareil;
use Faker\Provider\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppController extends Controller
{
    function login()
    {
        return view("page.login");
    }

    function login_submit(Request $request)
    {
        $request->validate([
            "contact" => "required",
            "password" => "required",
        ]);

        $user = User::where("contact", $request->contact)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route("home");
        }

        return back()->with("error_msg", "Contact ou mots de passe incorrect !");
    }

    function register()
    {
        return view("page.register");
    }

    function register_submit(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "prenom" => "required",
            "email" => "required",
            "contact" => "required",
            "password" => "required",
        ]);

        $user = new User();

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->token =  hash("sha256", time());
        $user->password =  Hash::make($request->password);

        $user->save();

        return redirect()->route("connexion");
    }



    function home()
    {
        $user = Auth::user();
        // dd($user->appareils()->count());
        // dd(UserAppareil::where([["user_id", $user->id],["status",1]])->get("appareil_id"));
        $data = [$user->appareils()->count(),UserAppareil::where([["user_id", $user->id],["status",1]])->count()];
        $appareils = Appareil::orderby("nom")->get();
        return view("page.home", ["user" => $user, "appareils" => $appareils, "data"=>$data]);
    }

    function vocal()
    {
        $user = Auth::user();
        $appareils = Appareil::orderby("nom")->get();
        return view("page.vocal",["user"=>$user]);
    }

    function piece_ajout(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "nom" => "required",
        ]);

        $piece = new Piece();
        $piece->libelle = $request->nom;
        $piece->user_id = $user->id;
        $piece->save();

        return back()->with("success_msg", "Piece ajouter avec succes !");
    }

    function user_appareil_ajout(Request $request)
    {
        $user = Auth::user();

        if (!$request->id_piece || !$request->id_appareil)
            return json_encode(["status" => false]);

        $appareil = new UserAppareil();
        $appareil->appareil_id = $request->id_appareil;
        $appareil->user_id = $user->id;
        $appareil->piece_id = $request->id_piece;
        $appareil->status = false;
        $appareil->save();

        return json_encode(["status" => $appareil]);
    }
    function piece_app_list($id)
    {

        $user = Auth::user();
        $piece = Piece::find($id);

        $appareil_id = UserAppareil::where("piece_id", $id)->get("appareil_id");
        $appareils = Appareil::whereIn("id", $appareil_id)->get();

        foreach ($appareils as $item) {
            $stat = UserAppareil::select("status")->where([["appareil_id", $item->id], ["piece_id", $id]])->first();

            $item->status = $stat->status;
        }

        return json_encode([$piece, $appareils]);
    }

    function piece_supp($id)
    {
        $user = Auth::user();
        $piece = Piece::find($id);

        if (!$piece)
            return back()->with("error_msg", "Piece invalide !");

        $piece->delete();

        return back()->with("success_msg", "Piece Suprimer avec succes !");
    }


    function list_appareil($id)
    {
        $user = Auth::user();
        $piece = Piece::find($id);

        if (!$piece)
            return back()->with("error_msg", "Piece invalide !");

        $piece->delete();

        return back()->with("success_msg", "Piece Suprimer avec succes !");
    }

    function status_appareil($appareil_id, $id_piece)
    {
        $user = Auth::user();
        $appareil = Appareil::find($appareil_id);
        $piece = Appareil::find($id_piece);

        if (!$appareil || !$piece)
            return json_encode(["status" => false]);

        $user_app = UserAppareil::where([["appareil_id", $appareil_id], ["piece_id", $id_piece], ["user_id", $user->id]])->first();

        if(!$user_app)
            return json_encode(["status" => false]);

        $user_app->status = !$user_app->status;
        $user_app->update();

        return json_encode(["status" => true]);
    }
}
