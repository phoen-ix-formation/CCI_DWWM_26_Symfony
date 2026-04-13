<?php

namespace App\Story;

use App\Factory\PokemonFactory;
use App\Factory\PokemonTypeFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

/**
 * Pour lancer la story :
 * symfony console foundry:load-fixtures main
 */
#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        // Génère 20 utilisateurs aléatoires via faker
        UserFactory::createMany(20);

        // Génère un utilisateur avec des attributs spécifiques
        UserFactory::createOne([
            'email'     => 'jdoe@app.net',
            'roles'     => ['ROLE_PROF'],
            'lastname'  => 'Doe',
            'firstname' => 'John'
        ]);

        // Génère tous les types des Pokémons
        PokemonTypeFactory::createSequence([
            ['name' => "Acier",    'color' => "#60A2B9"],
            ['name' => "Combat",   'color' => "#FF8100"],
            ['name' => "Dragon",   'color' => "#4F60E2"],
            ['name' => "Eau",      'color' => "#2481EF"],
            ['name' => "Electrik", 'color' => "#FAC100"],
            ['name' => "Fée",      'color' => "#EF70EF"],
            ['name' => "Feu",      'color' => "#E72324"],
            ['name' => "Glace",    'color' => "#3DD9FF"],
            ['name' => "Insecte",  'color' => "#92A212"],
            ['name' => "Normal",   'color' => "#A0A2A0"],
            ['name' => "Plante",   'color' => "#3DA224"],
            ['name' => "Poison",   'color' => "#923FCC"],
            ['name' => "Psy",      'color' => "#EF3F7A"],
            ['name' => "Roche",    'color' => "#B0AA82"],
            ['name' => "Sol",      'color' => "#92501B"],
            ['name' => "Spectre",  'color' => "#703F70"],
            ['name' => "Ténèbre",  'color' => "#4F3F3D"],
            ['name' => "Vol",      'color' => "#82BAEF"],
        ]);

        $objTypePlante  = PokemonTypeFactory::find(['name' => 'Plante']);
        $objTypePoison  = PokemonTypeFactory::find(['name' => 'Poison']);
        $objTypeFeu     = PokemonTypeFactory::find(['name' => 'Feu']);
        $objTypeVol     = PokemonTypeFactory::find(['name' => 'Vol']);
        $objTypeInsecte = PokemonTypeFactory::find(['name' => 'Insecte']);
        $objTypeEau     = PokemonTypeFactory::find(['name' => 'Eau']);
        $objTypeNormal  = PokemonTypeFactory::find(['name' => 'Normal']);
        $objTypeElectrik= PokemonTypeFactory::find(['name' => 'Electrik']);
        $objTypeSol     = PokemonTypeFactory::find(['name' => 'Sol']);
        $objTypeFee     = PokemonTypeFactory::find(['name' => 'Fée']);
        $objTypeCombat  = PokemonTypeFactory::find(['name' => 'Combat']);
        $objTypePsy     = PokemonTypeFactory::find(['name' => 'Psy']);
        $objTypeRoche   = PokemonTypeFactory::find(['name' => 'Roche']);
        $objTypeSpectre = PokemonTypeFactory::find(['name' => 'Spectre']);
        $objTypeGlace   = PokemonTypeFactory::find(['name' => 'Glace']);
        $objTypeAcier   = PokemonTypeFactory::find(['name' => 'Acier']);
        $objTypeDragon  = PokemonTypeFactory::find(['name' => 'Dragon']);

        PokemonFactory::createSequence([
            ['number' =>   1, 'name' => "Bulbizarre",   'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>   9, 'name' => "Tortank",      'types' => [$objTypeEau]],
            ['number' =>  10, 'name' => "Chenipan",     'types' => [$objTypeInsecte]],
            ['number' =>  11, 'name' => "Chrysacier",   'types' => [$objTypeInsecte]],
            ['number' =>   4, 'name' => "Salamèche",    'types' => [$objTypeFeu]],
            ['number' =>  41, 'name' => "Nosferapti",   'types' => [$objTypePoison, $objTypeVol]],
            ['number' =>   2, 'name' => "Herbizarre",   'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>   3, 'name' => "Florizarre",   'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  42, 'name' => "Nosferalto",   'types' => [$objTypePoison, $objTypeVol]],
            ['number' =>  43, 'name' => "Mystherbe",    'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  44, 'name' => "Ortide",       'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  45, 'name' => "Rafflesia",    'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  46, 'name' => "Paras",        'types' => [$objTypeInsecte, $objTypePlante]],
            ['number' =>  47, 'name' => "Parasect",     'types' => [$objTypeInsecte, $objTypePlante]],
            ['number' =>  48, 'name' => "Mimitoss",     'types' => [$objTypeInsecte, $objTypePoison]],
            ['number' =>  49, 'name' => "Aéromite",     'types' => [$objTypeInsecte, $objTypePoison]],
            ['number' =>   5, 'name' => "Reptincel",    'types' => [$objTypeFeu]],
            ['number' =>  20, 'name' => "Rattatac",     'types' => [$objTypeNormal]],
            ['number' =>  21, 'name' => "Piafabec",     'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  22, 'name' => "Rapasdepic",   'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  23, 'name' => "Abo",          'types' => [$objTypePoison]],
            ['number' =>  24, 'name' => "Arbok",        'types' => [$objTypePoison]],
            ['number' =>  25, 'name' => "Pikachu",      'types' => [$objTypeElectrik]],
            ['number' =>   6, 'name' => "Dracaufeu",    'types' => [$objTypeFeu, $objTypeVol]],
            ['number' =>   7, 'name' => "Carapuce",     'types' => [$objTypeEau]],
            ['number' =>   8, 'name' => "Carabaffe",    'types' => [$objTypeEau]],
            ['number' =>  12, 'name' => "Papilusion",   'types' => [$objTypeInsecte, $objTypeVol]],
            ['number' =>  13, 'name' => "Aspicot",      'types' => [$objTypeInsecte, $objTypePoison]],
            ['number' =>  14, 'name' => "Coconfort",    'types' => [$objTypeInsecte, $objTypePoison]],
            ['number' =>  15, 'name' => "Dardargnan",   'types' => [$objTypeInsecte, $objTypePoison]],
            ['number' =>  32, 'name' => "Nidoran♂",    'types' => [$objTypePoison]],
            ['number' =>  33, 'name' => "Nidorino",     'types' => [$objTypePoison]],
            ['number' =>  34, 'name' => "Nidoking",     'types' => [$objTypePoison, $objTypeSol]],
            ['number' =>  35, 'name' => "Mélofée",      'types' => [$objTypeFee]],
            ['number' =>  36, 'name' => "Mélodelfe",    'types' => [$objTypeFee]],
            ['number' =>  28, 'name' => "Sablaireau",   'types' => [$objTypeSol]],
            ['number' =>  29, 'name' => "Nidoran♀",    'types' => [$objTypePoison]],
            ['number' =>  30, 'name' => "Nidorina",     'types' => [$objTypePoison]],
            ['number' =>  31, 'name' => "Nidoqueen",    'types' => [$objTypePoison, $objTypeSol]],
            ['number' =>  38, 'name' => "Feunard",      'types' => [$objTypeFeu]],
            ['number' =>  39, 'name' => "Rondoudou",    'types' => [$objTypeNormal, $objTypeFee]],
            ['number' =>  40, 'name' => "Grodoudou",    'types' => [$objTypeNormal, $objTypeFee]],
            ['number' =>  50, 'name' => "Taupiqueur",   'types' => [$objTypeSol]],
            ['number' =>  51, 'name' => "Triopikeur",   'types' => [$objTypeSol]],
            ['number' =>  52, 'name' => "Miaouss",      'types' => [$objTypeNormal]],
            ['number' =>  53, 'name' => "Persian",      'types' => [$objTypeNormal]],
            ['number' =>  54, 'name' => "Psykokwak",    'types' => [$objTypeEau]],
            ['number' =>  55, 'name' => "Akwakwak",     'types' => [$objTypeEau]],
            ['number' =>  56, 'name' => "Férosinge",    'types' => [$objTypeCombat]],
            ['number' =>  57, 'name' => "Colossinge",   'types' => [$objTypeCombat]],
            ['number' =>  37, 'name' => "Goupix",       'types' => [$objTypeFeu]],
            ['number' =>  16, 'name' => "Roucool",      'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  17, 'name' => "Roucoups",     'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  18, 'name' => "Roucarnage",   'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  19, 'name' => "Rattata",      'types' => [$objTypeNormal]],
            ['number' =>  26, 'name' => "Raichu",       'types' => [$objTypeElectrik]],
            ['number' =>  27, 'name' => "Sabelette",    'types' => [$objTypeSol]],
            ['number' =>  58, 'name' => "Caninos",      'types' => [$objTypeFeu]],
            ['number' =>  59, 'name' => "Arcanin",      'types' => [$objTypeFeu]],
            ['number' =>  60, 'name' => "Ptitard",      'types' => [$objTypeEau]],
            ['number' =>  61, 'name' => "Têtarte",      'types' => [$objTypeEau]],
            ['number' =>  62, 'name' => "Tartard",      'types' => [$objTypeEau, $objTypeCombat]],
            ['number' =>  63, 'name' => "Abra",         'types' => [$objTypePsy]],
            ['number' =>  64, 'name' => "Kadabra",      'types' => [$objTypePsy]],
            ['number' =>  65, 'name' => "Alakazam",     'types' => [$objTypePsy]],
            ['number' =>  66, 'name' => "Machoc",       'types' => [$objTypeCombat]],
            ['number' =>  67, 'name' => "Machopeur",    'types' => [$objTypeCombat]],
            ['number' =>  68, 'name' => "Mackogneur",   'types' => [$objTypeCombat]],
            ['number' =>  69, 'name' => "Chétiflor",    'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  70, 'name' => "Boustiflor",   'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  71, 'name' => "Empiflor",     'types' => [$objTypePlante, $objTypePoison]],
            ['number' =>  72, 'name' => "Tentacool",    'types' => [$objTypeEau, $objTypePoison]],
            ['number' =>  73, 'name' => "Tentacruel",   'types' => [$objTypeEau, $objTypePoison]],
            ['number' =>  74, 'name' => "Racaillou",    'types' => [$objTypeRoche, $objTypeSol]],
            ['number' =>  75, 'name' => "Gravalanch",   'types' => [$objTypeRoche, $objTypeSol]],
            ['number' =>  76, 'name' => "Grolem",       'types' => [$objTypeRoche, $objTypeSol]],
            ['number' =>  77, 'name' => "Ponyta",       'types' => [$objTypeFeu]],
            ['number' =>  78, 'name' => "Galopa",       'types' => [$objTypeFeu]],
            ['number' =>  79, 'name' => "Ramoloss",     'types' => [$objTypeEau, $objTypePsy]],
            ['number' =>  80, 'name' => "Flagadoss",    'types' => [$objTypeEau, $objTypePsy]],
            ['number' =>  81, 'name' => "Magnéti",      'types' => [$objTypeElectrik, $objTypeAcier]],
            ['number' =>  82, 'name' => "Magnéton",     'types' => [$objTypeElectrik, $objTypeAcier]],
            ['number' =>  83, 'name' => "Canarticho",   'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  84, 'name' => "Doduo",        'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  85, 'name' => "Dodrio",       'types' => [$objTypeNormal, $objTypeVol]],
            ['number' =>  86, 'name' => "Otaria",       'types' => [$objTypeEau]],
            ['number' =>  87, 'name' => "Lamantine",    'types' => [$objTypeEau, $objTypeGlace]],
            ['number' =>  88, 'name' => "Tadmorv",      'types' => [$objTypePoison]],
            ['number' =>  89, 'name' => "Grotadmorv",   'types' => [$objTypePoison]],
            ['number' =>  90, 'name' => "Kokiyas",      'types' => [$objTypeEau]],
            ['number' =>  91, 'name' => "Crustabri",    'types' => [$objTypeEau, $objTypeGlace]],
            ['number' =>  92, 'name' => "Fantominus",   'types' => [$objTypeSpectre, $objTypePoison]],
            ['number' =>  93, 'name' => "Spectrum",     'types' => [$objTypeSpectre, $objTypePoison]],
            ['number' =>  94, 'name' => "Ectoplasma",   'types' => [$objTypeSpectre, $objTypePoison]],
            ['number' =>  95, 'name' => "Onix",         'types' => [$objTypeRoche, $objTypeSol]],
            ['number' =>  96, 'name' => "Soporifik",    'types' => [$objTypePsy]],
            ['number' =>  97, 'name' => "Hypnomade",    'types' => [$objTypePsy]],
            ['number' =>  98, 'name' => "Krabby",       'types' => [$objTypeEau]],
            ['number' =>  99, 'name' => "Krabboss",     'types' => [$objTypeEau]],
            ['number' => 100, 'name' => "Voltorbe",     'types' => [$objTypeElectrik]],
            ['number' => 101, 'name' => "Électrode",    'types' => [$objTypeElectrik]],
            ['number' => 102, 'name' => "Nœunœuf",      'types' => [$objTypePlante, $objTypePsy]],
            ['number' => 103, 'name' => "Noadkoko",     'types' => [$objTypePlante, $objTypePsy]],
            ['number' => 104, 'name' => "Osselait",     'types' => [$objTypeSol]],
            ['number' => 105, 'name' => "Ossatueur",    'types' => [$objTypeSol]],
            ['number' => 106, 'name' => "Kicklee",      'types' => [$objTypeCombat]],
            ['number' => 107, 'name' => "Tygnon",       'types' => [$objTypeCombat]],
            ['number' => 108, 'name' => "Excelangue",   'types' => [$objTypeNormal]],
            ['number' => 109, 'name' => "Smogo",        'types' => [$objTypePoison]],
            ['number' => 110, 'name' => "Smogogo",      'types' => [$objTypePoison]],
            ['number' => 111, 'name' => "Rhinocorne",   'types' => [$objTypeSol, $objTypeRoche]],
            ['number' => 112, 'name' => "Rhinoféros",   'types' => [$objTypeSol, $objTypeRoche]],
            ['number' => 113, 'name' => "Leveinard",    'types' => [$objTypeNormal]],
            ['number' => 114, 'name' => "Saquedeneu",   'types' => [$objTypePlante]],
            ['number' => 115, 'name' => "Kangourex",    'types' => [$objTypeNormal]],
            ['number' => 116, 'name' => "Hypotrempe",   'types' => [$objTypeEau]],
            ['number' => 117, 'name' => "Hypocean",     'types' => [$objTypeEau]],
            ['number' => 118, 'name' => "Poissirène",   'types' => [$objTypeEau]],
            ['number' => 119, 'name' => "Poissoroy",    'types' => [$objTypeEau]],
            ['number' => 120, 'name' => "Stari",        'types' => [$objTypeEau]],
            ['number' => 121, 'name' => "Staross",      'types' => [$objTypeEau, $objTypePsy]],
            ['number' => 122, 'name' => "M. Mime",      'types' => [$objTypePsy, $objTypeFee]],
            ['number' => 123, 'name' => "Insécateur",   'types' => [$objTypeInsecte, $objTypeVol]],
            ['number' => 124, 'name' => "Lippoutou",    'types' => [$objTypeGlace, $objTypePsy]],
            ['number' => 125, 'name' => "Élektek",      'types' => [$objTypeElectrik]],
            ['number' => 126, 'name' => "Magmar",       'types' => [$objTypeFeu]],
            ['number' => 127, 'name' => "Scarabrute",   'types' => [$objTypeInsecte]],
            ['number' => 128, 'name' => "Tauros",       'types' => [$objTypeNormal]],
            ['number' => 129, 'name' => "Magicarpe",    'types' => [$objTypeEau]],
            ['number' => 130, 'name' => "Léviator",     'types' => [$objTypeEau, $objTypeVol]],
            ['number' => 131, 'name' => "Lokhlass",     'types' => [$objTypeEau, $objTypeGlace]],
            ['number' => 132, 'name' => "Métamorph",    'types' => [$objTypeNormal]],
            ['number' => 133, 'name' => "Évoli",        'types' => [$objTypeNormal]],
            ['number' => 134, 'name' => "Aquali",       'types' => [$objTypeEau]],
            ['number' => 135, 'name' => "Voltali",      'types' => [$objTypeElectrik]],
            ['number' => 136, 'name' => "Pyroli",       'types' => [$objTypeFeu]],
            ['number' => 137, 'name' => "Porygon",      'types' => [$objTypeNormal]],
            ['number' => 138, 'name' => "Amonita",      'types' => [$objTypeRoche, $objTypeEau]],
            ['number' => 139, 'name' => "Amonistar",    'types' => [$objTypeRoche, $objTypeEau]],
            ['number' => 140, 'name' => "Kabuto",       'types' => [$objTypeRoche, $objTypeEau]],
            ['number' => 141, 'name' => "Kabutops",     'types' => [$objTypeRoche, $objTypeEau]],
            ['number' => 142, 'name' => "Aérodactyle",  'types' => [$objTypeRoche, $objTypeVol]],
            ['number' => 143, 'name' => "Ronflex",      'types' => [$objTypeNormal]],
            ['number' => 144, 'name' => "Artikodin",    'types' => [$objTypeGlace, $objTypeVol]],
            ['number' => 145, 'name' => "Électhor",     'types' => [$objTypeElectrik, $objTypeVol]],
            ['number' => 146, 'name' => "Sulfura",      'types' => [$objTypeFeu, $objTypeVol]],
            ['number' => 147, 'name' => "Minidraco",    'types' => [$objTypeDragon]],
            ['number' => 148, 'name' => "Draco",        'types' => [$objTypeDragon]],
            ['number' => 149, 'name' => "Dracolosse",   'types' => [$objTypeDragon, $objTypeVol]],
            ['number' => 150, 'name' => "Mewtwo",       'types' => [$objTypePsy]],
            ['number' => 151, 'name' => "Mew",          'types' => [$objTypePsy]],
        ]);
    }
}
