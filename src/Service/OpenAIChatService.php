<?php
 

namespace App\Service;

use App\Form\Model\VideoModel;
use LLPhant\Chat\Enums\OpenAIChatModel;
use LLPhant\Chat\FunctionInfo\FunctionBuilder;
use LLPhant\Chat\FunctionInfo\Parameter;
use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class OpenAIChatService
{
  public function __construct(
    #[Autowire('%open_ai_api_key%')] private readonly string $openAiApiKey,
    private readonly VideoService $videoService

  ) {}

  public function createVideo(VideoModel $model): void
  {

    $chat = $this->openAiChat();
    /* $parameters = [
      new Parameter('title', 'string', 'The title of the video'),
      new Parameter('description', 'string', 'The description of the video'),
      new Parameter('tags', 'array', 'An array of tags for the video', ['type' => 'string'])
    ];*/

    $tool = FunctionBuilder::buildFunctionInfo($this->videoService, 'createVideo');
     
    $chat->addTool($tool);

    $chat->setSystemMessage('Vous ête un assistant IA serviable. Vous pouvez m\'aider à créer une vidéo à partir du titre, description et de tags ? ');
    $text = \sprintf(
      'Créer une vidéo avec le titre "%s", la description ayant entre %d et %d caractères et ayant pour nombre de tags : %d',
      $model->subject,
      $model->descriptionSize->minNumberOfCharacters(),
      $model->descriptionSize->maxNumberOfCharacters(),
      $model->numberOfTags
    );

    $chat->generateText(
      $text
    );
  }

  private function openAiChat(): OpenAIChat
  {
    $config = new OpenAIConfig();
    $config->apiKey = $this->openAiApiKey;
    $config->model = OpenAIChatModel::Gpt35Turbo->value;

    return new OpenAIChat($config);
  }
}
