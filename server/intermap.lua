class "InteractiveMap"
function InteractiveMap:__init()
    self.lastTime = os.time()

    Events:Subscribe("PostTick", self, self.PostTick)
end

function InteractiveMap:PostTick(args)
    if os.difftime(os.time(), self.lastTime) >= 1 then
        file = io.open("intermap.txt", "w");
        out = ""
        for player in Server:GetPlayers() do
            local playerPos = player:GetPosition()
            out = out.."\n"..player:GetName()..","..playerPos.x..","..playerPos.z
        end
        file:write(out)
        file:close()
        self.lastTime = os.time()
    end
end

im = InteractiveMap()