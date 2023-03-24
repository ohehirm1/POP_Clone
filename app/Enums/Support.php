<?php

namespace App\Enums;

enum Support: string
{
    case AssistanceWithDailyLife = '01';
    case Transport = '02';
    case Consumables = '03';
    case AssistanceWithSocialEconomicAndCommunityParticipation = '04';
    case AssistiveTechnology = '05';
    case HomeModificationsAndSpecialisedDisabilityAccomodation = '06';
    case SupportCoordination = '07';
    case ImprovedLivingArrangements = '08';
    case IncreasedSocialAndCommunityParticipation = '09';
    case FindingAndKeepingAJob = '10';
    case ImprovedRelationships = '11';
    case ImprovedHealthAndWellbeing = '12';
    case ImprovedLearning = '13';
    case ImprovedLifeChoices = '14';
    case ImprovedDailyLivingSkills = '15';
}
