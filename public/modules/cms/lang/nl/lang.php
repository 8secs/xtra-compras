<?php

return [
    'cms_object' => [
        'invalid_file' => 'Ongeldige bestandsnaam: :name. Bestandsnamen mogen enkel bestaan uit letters, cijfers, underscores, streepjes en punten. Voorbeelden van correcte bestandsnamen: pagina.htm, pagina, map/pagina',
        'invalid_property' => 'Parameter ":name" kan niet worden gewijzigd',
        'file_already_exists' => 'Bestand ":name" bestaat al.',
        'error_saving' => 'Bestand opslaan mislukt: ":name". Controleer de schrijfrechten.',
        'error_creating_directory' => 'Map aanmaken mislukt: ":name". Controleer de schrijfrechten.',
        'invalid_file_extension' => 'Ongeldige bestandsextensie: :invalid. Toegestane extensies zijn: :allowed.',
        'error_deleting' => 'Fout bij het verwijderen van template: ":name". Controleer de schrijfrechten.',
        'delete_success' => 'Templates zijn succesvol verwijderd: :count.',
        'file_name_required' => 'Het invullen van een bestandsnaam is verplicht.',
        'safe_mode_enabled' => 'Safe-modus is op dit moment ingeschakeld.',
    ],
    'dashboard' => [
        'active_theme' => [
            'widget_title_default' => 'Website',
            'online' => 'online',
            'maintenance' => 'in onderhoud',
            'manage_themes' => 'Beheer thema\'s',
        ],
    ],
    'theme' => [
        'not_found_name' => 'Het thema \':name\' is niet gevonden.',
        'active' => [
            'not_set' => 'Er is geen actief thema geselecteerd.',
            'not_found' => 'Het actieve thema is niet gevonden.',
        ],
        'edit' => [
            'not_set' => 'Er is geen thema ingesteld om te kunnen bewerken.',
            'not_found' => 'Het te bewerken thema is niet gevonden.',
            'not_match' => 'Het object dat je probeert te openen behoort niet tot het te bewerken thema. Herlaad de pagina.',
        ],
        'settings_menu' => 'Front-end thema',
        'settings_menu_description' => 'Bekijk de lijst met geïnstalleerde thema\'s en selecteer een beschikbaar thema.',
        'default_tab' => 'Eigenschappen',
        'name_label' => 'Naam',
        'name_create_placeholder' => 'Thema naam',
        'author_label' => 'Auteur',
        'author_placeholder' => 'Naam of bedrijfsnaam',
        'description_label' => 'Omschrijving',
        'description_placeholder' => 'Thema omschrijving',
        'homepage_label' => 'Website',
        'homepage_placeholder' => 'Website URL',
        'code_label' => 'Code',
        'code_placeholder' => 'Een unieke code voor dit thema (wordt gebruikt voor distributie)',
        'dir_name_label' => 'Mapnaam',
        'dir_name_create_label' => 'Mapnaam van het thema',
        'theme_label' => 'Thema',
        'theme_title' => 'Thema\'s',
        'activate_button' => 'Activeren',
        'active_button' => 'Activeren',
        'customize_theme' => 'Thema aanpassen',
        'customize_button' => 'Aanpassen',
        'duplicate_button' => 'Dupliceren',
        'duplicate_title' => 'Dupliceer thema',
        'duplicate_theme_success' => 'Thema succesvol gedupliceerd!',
        'manage_button' => 'Beheer',
        'manage_title' => 'Beheer thema',
        'edit_properties_title' => 'Thema',
        'edit_properties_button' => 'Wijzig eigenschappen',
        'save_properties' => 'Eigenschappen opslaan',
        'import_button' => 'Importeren',
        'import_title' => 'Importeer thema',
        'import_theme_success' => 'Thema succesvol geïmporteerd!',
        'import_uploaded_file' => 'Thema archiefbestand',
        'import_overwrite_label' => 'Overschijf bestaande bestanden',
        'import_overwrite_comment' => 'Untick this box to only import new files',
        'import_folders_label' => 'Mappen',
        'import_folders_comment' => 'Selecteer de mappen die je wilt importeren:',
        'export_button' => 'Exporteren',
        'export_title' => 'Exporteer thema',
        'export_folders_label' => 'Mappen',
        'export_folders_comment' => 'Selecteer de mappen die je wilt exporteren:',
        'delete_button' => 'Verwijderen',
        'delete_confirm' => 'Weet je zeker dat je dit thema wilt verwijderen? Dit kan niet ongedaan worden gemaakt!',
        'delete_active_theme_failed' => 'Kan het actieve thema niet verwijderen, maak eerst een ander thema actief.',
        'delete_theme_success' => 'Thema succesvol verwijderd!',
        'create_title' => 'Thema aanmaken',
        'create_button' => 'Aanmaken',
        'create_new_blank_theme' => 'Maak een nieuw leeg thema',
        'create_theme_success' => 'Thema succesvol aangemaakt!',
        'create_theme_required_name' => 'Geef a.u.b. een naam op voor dit thema.',
        'new_directory_name_label' => 'Thema mapnaam',
        'new_directory_name_comment' => 'Geef een nieuwe mapnaam op voor het gedupliceerde thema.',
        'dir_name_invalid' => 'Naam mag alleen cijfers, letters en de volgende symbolen bevatten: _-',
        'dir_name_taken' => 'Opgegeven mapnaam bestaat reeds.',
        'find_more_themes' => 'Zoek meer thema\'s',
        'saving' => 'Thema opslaan...',
        'return' => 'Terug naar thema lijst',
    ],
    'maintenance' => [
        'settings_menu' => 'Onderhoudsmodus',
        'settings_menu_description' => 'Instellingen voor de onderhoudsmodus pagina.',
        'is_enabled' => 'Onderhoudsmodus inschakelen',
        'is_enabled_comment' => 'Toon de volgende pagina als onderhoudsmodus is ingeschakeld:',
        'hint' => 'Onderhoudsmodus zal de onderhoudspagina tonen aan bezoekers die niet ingelogd zijn in het CMS.',
    ],
    'page' => [
        'not_found_name' => 'De pagina \':name\' is niet gevonden.',
        'not_found' => [
            'label' => 'Pagina niet gevonden',
            'help' => 'De opgevraagde pagina kan niet worden gevonden.',
        ],
        'custom_error' => [
            'label' => 'Paginafout',
            'help' => 'Onze excuses, er is iets mis gegaan. De opgevraagde pagina kan niet worden getoond.',
        ],
        'menu_label' => 'Pagina\'s',
        'unsaved_label' => 'Niet opgeslagen pagina\'s',
        'no_list_records' => 'Geen pagina\'s gevonden',
        'new' => 'Nieuwe pagina',
        'invalid_url' => 'Ongeldig URL formaat. De URL moet beginnen met een schuine streep en mag enkel bestaan uit letters, cijfers en de volgende tekens: ._-[]:?|/+*^$',
        'delete_confirm_multiple' => 'Weet je zeker dat je de geselecteerde pagina\'s wilt verwijderen?',
        'delete_confirm_single' => 'Weet je zeker dat je deze pagina wilt verwijderen?',
        'no_layout' => '-- geen layout --',
    ],
    'layout' => [
        'not_found_name' => "De layout ':name' is niet gevonden",
        'menu_label' => 'Layouts',
        'unsaved_label' => 'Niet opgeslagen layouts',
        'no_list_records' => 'Geen layouts gevonden',
        'new' => 'Nieuwe layout',
        'delete_confirm_multiple' => 'Weet je zeker dat je de geselecteerde layouts wilt verwijderen?',
        'delete_confirm_single' => 'Weet je zeker dat je deze layout wilt verwijderen?',
    ],
    'partial' => [
        'not_found_name' => 'Het sjabloon (partial) \':name\' is niet gevonden.',
        'invalid_name' => 'Ongeldige naam voor sjabloon (partial): :name.',
        'menu_label' => 'Sjablonen',
        'unsaved_label' => 'Niet opgeslagen sjablonen',
        'no_list_records' => 'Geen sjablonen (partial) gevonden',
        'delete_confirm_multiple' => 'Weet je zeker dat je de geselecteerde sjablonen wilt verwijderen?',
        'delete_confirm_single' => 'Weet je zeker dat je dit sjabloon wilt verwijderen?',
        'new' => 'Nieuw sjabloon',
    ],
    'content' => [
        'not_found_name' => "Het tekstblok (content) ':name' is niet gevonden.",
        'menu_label' => 'Tekstblokken',
        'unsaved_label' => 'Niet opgeslagen tekstblokken',
        'no_list_records' => 'Geen tekstblokken (content) gevonden',
        'delete_confirm_multiple' => 'Weet je zeker dat je de geselecteerde tekstblokken of mappen wilt verwijderen?',
        'delete_confirm_single' => 'Weet je zeker dat je dit tekstblok wilt verwijderen?',
        'new' => 'Nieuw tekstblok',
    ],
    'ajax_handler' => [
        'invalid_name' => 'Ongeldige AJAX handlernaam: :name.',
        'not_found' => 'AJAX handler \':name\' is niet gevonden.',
    ],
    'cms' => [
        'menu_label' => 'CMS',
    ],
    'sidebar' => [
        'add' => 'Toevoegen',
        'search' => 'Zoeken...',
    ],
    'editor' => [
        'settings' => 'Instellingen',
        'title' => 'Titel',
        'new_title' => 'Nieuwe paginatitel',
        'url' => 'URL',
        'filename' => 'Bestandsnaam',
        'layout' => 'Layout',
        'description' => 'Omschrijving',
        'preview' => 'Voorbeeld',
        'meta' => 'Meta',
        'meta_title' => 'Meta titel',
        'meta_description' => 'Meta omschrijving',
        'markup' => 'Opmaak',
        'code' => 'Code',
        'content' => 'Content',
        'hidden' => 'Verborgen',
        'hidden_comment' => 'Verborgen pagina zijn alleen toegankelijk voor ingelogde gebruikers.',
        'enter_fullscreen' => 'Volledig scherm starten',
        'exit_fullscreen' => 'Volledig scherm afsluiten',
        'open_searchbox' => 'Open zoekveld',
        'close_searchbox' => 'Sluit zoekveld',
        'open_replacebox' => 'Open vervang veld',
        'close_replacebox' => 'Sluit vervang veld',
    ],
    'asset' => [
        'menu_label' => 'Middelen',
        'unsaved_label' => 'Niet opgeslagen middelen',
        'drop_down_add_title' => 'Toevoegen...',
        'drop_down_operation_title' => 'Actie...',
        'upload_files' => 'Bestand(en) uploaden',
        'create_file' => 'Nieuw bestand',
        'create_directory' => 'Nieuwe map',
        'directory_popup_title' => 'Nieuwe map',
        'directory_name' => 'Mapnaam',
        'rename' => 'Hernoemen',
        'delete' => 'Verwijderen',
        'move' => 'Verplaatsen',
        'select' => 'Selecteren',
        'new' => 'Nieuw bestand',
        'rename_popup_title' => 'Hernoemen',
        'rename_new_name' => 'Nieuwe naam',
        'invalid_path' => 'Pad mag enkel bestaan uit letters, cijfers, spaties en de volgende tekens: ._-/',
        'error_deleting_file' => 'Fout bij verwijderen van het bestand :name.',
        'error_deleting_dir_not_empty' => 'Fout bij verwijderen van map :name. De map is niet leeg.',
        'error_deleting_dir' => 'Fout bij verwijderen van de map :name.',
        'invalid_name' => 'Naam mag enkel bestaan uit letters, cijfers, spaties en de volgende tekens: ._-',
        'original_not_found' => 'Oorspronkelijke bestand of map is niet gevonden',
        'already_exists' => 'Bestand of map met deze naam bestaat al',
        'error_renaming' => 'Fout bij hernoemen van bestand of map',
        'name_cant_be_empty' => 'De naam mag niet leeg zijn',
        'too_large' => 'Het geüploadete bestand is te groot. De maximaal toegestane bestandsgrootte is :max_size',
        'type_not_allowed' => 'Enkel de volgende bestandstypen zijn toegestaand: :allowed_types',
        'file_not_valid' => 'Bestand is ongeldig',
        'error_uploading_file' => 'Fout tijdens uploaden bestand ":name": :error',
        'move_please_select' => 'selecteer',
        'move_destination' => 'Doelmap',
        'move_popup_title' => 'Verplaats middelen',
        'move_button' => 'Verplaats',
        'selected_files_not_found' => 'Geselecteerde bestanden zijn niet gevonden',
        'select_destination_dir' => 'Selecteer een doelmap',
        'destination_not_found' => 'Doelmap is niet gevonden',
        'error_moving_file' => 'Fout bij verplaatsen bestand :file',
        'error_moving_directory' => 'Fout bij verplaatsen map :dir',
        'error_deleting_directory' => 'Fout bij het verwijderen van de oorspronkelijke map :dir',
        'path' => 'Pad',
    ],
    'component' => [
        'menu_label' => 'Componenten',
        'unnamed' => 'Naamloos',
        'no_description' => 'Geen beschrijving opgegeven',
        'alias' => 'Alias',
        'alias_description' => 'Een unieke naam voor dit component voor gebruik in de code van een pagina of layout.',
        'validation_message' => 'Een alias voor het component is verplicht en mag alleen bestaan uit letters, cijfers en underscores. De alias moet beginnen met een letter.',
        'invalid_request' => 'De template kan niet worden opgeslagen vanwege ongeldige componentgegevens.',
        'no_records' => 'Geen componenten gevonden',
        'not_found' => 'Het component \':name\' is niet gevonden.',
        'method_not_found' => 'Het component \':name\' bevat geen \':method\' methode.',
    ],
    'template' => [
        'invalid_type' => 'Onbekend type template.',
        'not_found' => 'De opgevraagde template is niet gevonden.',
        'saved' => 'De template is succesvol opgeslagen.',
    ],
    'permissions' => [
        'name' => 'Cms',
        'manage_content' => 'Beheer inhoud',
        'manage_assets' => 'Beheer middelen',
        'manage_pages' => 'Beheer pagina\'s',
        'manage_layouts' => 'Beheer layouts',
        'manage_partials' => 'Beheer sjablonen',
        'manage_themes' => 'Beheer thema\'s',
        'manage_media' => 'Beheer media',
    ],
    'mediafinder' => [
        'default_prompt' => 'Klik op de %s knop om een media item te vinden',
    ],
    'media' => [
        'invalid_path' => 'Ongeldig pad opgegeven: \':path\'.',
        'menu_label' => 'Media',
        'upload' => 'Uploaden',
        'move' => 'Verplaatsen',
        'delete' => 'Verwijderen',
        'add_folder' => 'Map toevoegen',
        'search' => 'Zoeken',
        'display' => 'Weergeven',
        'filter_everything' => 'Alles',
        'filter_images' => 'Afbeeldingen',
        'filter_video' => 'Video\'s',
        'filter_audio' => 'Audio',
        'filter_documents' => 'Documenten',
        'library' => 'Bibliotheek',
        'folder_size_items' => 'item(s)',
        'size' => 'Grootte',
        'title' => 'Titel',
        'last_modified' => 'Laatst gewijzigd',
        'public_url' => 'URL',
        'click_here' => 'Klik hier',
        'thumbnail_error' => 'Fout opgetreden bij genereren miniatuurweergave.',
        'return_to_parent' => 'Terug naar bovenliggende map',
        'return_to_parent_label' => 'Naar bovenliggende ...',
        'nothing_selected' => 'Er is niets geselecteerd.',
        'multiple_selected' => 'Meerdere items geselecteerd.',
        'uploading_file_num' => 'Uploaden van :number bestanden...',
        'uploading_complete' => 'Uploaden voltooid',
        'uploading_error' => 'Upload mislukt',
        'type_blocked' => 'Het bestandstype is i.v.m. veiligheidsredenen geblokkeerd.',
        'order_by' => 'Sorteer op',
        'folder' => 'Map',
        'no_files_found' => 'Er zijn geen bestanden gevonden.',
        'delete_empty' => 'Selecteer items om te verwijderen.',
        'delete_confirm' => 'Weet je zeker dat je de geselecteerde items wilt verwijderen?',
        'error_renaming_file' => 'Fout bij wijzigen naam.',
        'new_folder_title' => 'Nieuwe map',
        'folder_name' => 'Mapnaam',
        'error_creating_folder' => 'Fout bij maken van map',
        'folder_or_file_exist' => 'Er bestaat reeds een map of bestand met deze naam.',
        'move_empty' => 'Selecteer de items om te verplaatsen.',
        'move_popup_title' => 'Verplaats bestanden of mappen',
        'move_destination' => 'Doelmap',
        'please_select_move_dest' => 'Selecteer een doelmap.',
        'move_dest_src_match' => 'Selecteer een andere doelmap.',
        'empty_library' => 'De media bibliotheek is leeg. Upload bestanden of maak mappen aan om te beginnen.',
        'insert' => 'Invoegen',
        'crop_and_insert' => 'Uitsnijden & Invoegen',
        'select_single_image' => 'Selecteer één afbeelding.',
        'selection_not_image' => 'Het geselecteerde item is geen afbeelding.',
        'restore' => 'Alle wijzigingen ongedaan maken',
        'resize' => 'Wijzig grootte...',
        'selection_mode_normal' => 'Normaal',
        'selection_mode_fixed_ratio' => 'Vaste ratio',
        'selection_mode_fixed_size' => 'Vaste grootte',
        'height' => 'Hoogte',
        'width' => 'Breedte',
        'selection_mode' => 'Selectie modus',
        'resize_image' => 'Wijzig grootte van afbeelding',
        'image_size' => 'Grootte afbeelding:',
        'selected_size' => 'Geselecteerd:',
    ],
];
