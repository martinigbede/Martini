<?php

namespace App\Livewire\Contact;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
// use App\Mail\ContactMessage; // À décommenter si vous avez créé un Mailable

class PublicContactForm extends Component
{
    // Propriétés qui correspondent aux champs du formulaire HTML
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $subject;
    public $message;

    public $formSubmitted = false; // Pour afficher un message de succès

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ];
    }

    public function submitForm()
    {
        $this->validate();

        $formData = [
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
        ];
        
        // --- LOGIQUE D'ENVOI D'EMAIL (À DÉCOMMENTER ET ADAPTER) ---
        /*
        try {
            Mail::to(config('mail.to.support_email', 'contact@miadjoeresort.com'))->send(new ContactMessage($formData));
            $this->formSubmitted = true;
            $this->resetInput();
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer.');
        }
        */
        
        // SIMULATION : Si vous n'avez pas configuré Mail, vous pouvez afficher un message de succès
        $this->formSubmitted = true;
        $this->resetInput();
        session()->flash('message', 'Votre message a bien été envoyé. Nous vous répondrons rapidement.');
    }

    public function resetInput()
    {
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact.public-contact-form');
    }
}