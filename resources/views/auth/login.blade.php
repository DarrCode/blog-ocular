@extends('layouts.app')

@section('content')
<v-container>
    <v-row>
        <v-col cols="12">
            <v-card max-width="600" class="mx-auto">
                <v-card-title>Inicio de sesion</v-card-title>
                <v-card-text>solo para administradores</<v-card-text>
                <v-card-text>
                    <v-form method="POST" action="{{ route('login') }}">
                        @csrf
            
                        <v-text-field
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required autofocus
                            label="Email"
                        ></v-text-field>
                        <v-text-field
                            id="password" 
                            type="password" 
                            name="password" 
                            label="Password"
                            required 
                        ></v-text-field>                
            
                        <v-btn
                        dark
                        class="bg-primary fw-bold"
                        type="submit"
                        >
                        INGRESAR 
                        </v-btn>          
                    </v-form>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>

@endsection
