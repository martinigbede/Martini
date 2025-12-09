@component('mail::message')
# Notification Paiement SEMOA (CashPay)

Un paiement SEMOA vient d'être traité.

## Détails du paiement
- Statut: {{ $payment->statut }}
- Montant payé: {{ $payment->montant }} XOF
- Transaction: {{ $payment->transaction_id }}

## Détails de la réservation
- Réservation ID: {{ $reservation->id }}

## Chambres réservées
@foreach ($reservation->items as $item)
- Chambre n°{{ $item->room->numero ?? 'N/A' }}
  (Type : {{ $item->room->roomType->nom ?? 'Non défini' }})
  - Quantité: {{ $item->quantite }}
  - Personnes: {{ $item->nb_personnes }}
  @if($item->lit_dappoint)
    - Lit d’appoint: Oui
    - Nombre de lits d’appoint: {{ $item->nb_lits_dappoint ?? 0 }}
  @else
    - Lit d’appoint: Non
  @endif
@endforeach

## Client
- Nom : {{ $reservation->client->nom }} {{ $reservation->client->prenom }}
- Téléphone : {{ $reservation->client->telephone }}
- Email : {{ $reservation->client->email }}

## Séjour
- Du {{ $reservation->check_in }} au {{ $reservation->check_out }}
- Statut : {{ $reservation->statut }}

@endcomponent
