<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Exibe o formulário de login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Autentica o usuário.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
        ]);

        if (! Auth::attempt(
            $credentials, $request->boolean('remember')
        )) {
            return back()->withErrors([
                'email' => 'Credenciais inválidas, tente novamente.',
            ])
                ->onlyInput('email');
        }

        /*
         * Importantíssimo após autenticar.
         *
         * Evita manter o mesmo ID de sessão que existia
         * antes do login.
         */
        $request->session()->regenerate();

        /*
         * Se o middleware auth havia interceptado uma URL,
         * Laravel volta para ela.
         *
         * Caso contrário, vai para a home.
         */
        return redirect()->intended('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
