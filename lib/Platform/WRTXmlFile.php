<?php
class Platform_WRTXmlFile implements PlatformInterface {
	private $filename;

	public function __construct(array $config) {
		$this->filename = $config['filename'];
	}

	public function send(Metadata $meta) {
		$doc = new DomDocument('1.0', 'utf-8');

		// -- Création de l'arbre
		$racine = $doc->createElement("WebRadioTools");

		// Timestamp
		$timestamp = $doc->createElement("timestamp");
		$timestamp->appendChild($doc->createTextNode(time()));

		$racine->appendChild($timestamp);

		// -- Enfants de <onair>
		$onair = $doc->createElement("onair");

		$dispTitle = $doc->createElement("displayed_title");
		$dispTitle->appendChild($doc->createTextNode($meta->Oneliner));
		$onair->appendChild($dispTitle);

		$song = $doc->createElement("song");

		// -- Enfants de song
		$titleTag = $doc->createElement("title");
		$titleTag->appendChild($doc->createTextNode($meta->Title));

		$start = $doc->createElement("start");
		$start->appendChild($doc->createTextNode(time()));

		$artistTag = $doc->createElement("artist");

		$alias = $doc->createElement("alias");
		$alias->appendChild($doc->createTextNode($meta->Artist));
		$artistTag->appendChild($alias);

		$song->appendChild($titleTag);
		$song->appendChild($start);
		$song->appendChild($artistTag);

		$onair->appendChild($song);

		$racine->appendChild($onair);

		$doc->appendChild($racine);

		$doc->save($this->filename);
	}
}
?>
